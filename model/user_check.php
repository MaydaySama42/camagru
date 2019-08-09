<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   check_user.php                                     :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/02 18:04:16 by mayday            #+#    #+#             */
/*   Updated: 2019/08/02 18:04:16 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("../config/database.php");

define("REGEX_MAIL", "/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*(\-[a-zA-Z0-9]+)*\.[a-zA-Z0-9]{2,4}$/");
define("REGEX_USERNAME", "/^[a-zA-Z0-9]+(\_[a-zA-Z0-9]+)*$/");
define("REGEX_PASSWORD", "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/");

function checkMailIsValid($mail)
{
	if (preg_match(REGEX_MAIL, $mail) == 0)
		return (1);
	return (0);
}

function checkUserNameIsValid($user_name)
{
	if (preg_match(REGEX_USERNAME, $user_name) == 0)
		return (1);
	return (0);
}

function checkPasswordIsValid($password, $confirm_password)
{
	if (preg_match(REGEX_PASSWORD, $password) == 0)
		return (1);
	if (strlen($password) < 8)
		return (1);
	if ($password != $confirm_password)
		return (2);
	return (0);
}

function checkMailAlreadyExists($mail)
{
	global $database;

	$query = $database->prepare("SELECT user_id FROM user WHERE user_mail = :mail");
	$query->execute(['mail' => $mail]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$res = $query->fetch();
	if (!empty($res))
		return (1);
	$query->closeCursor();
	return (0);
}

function checkUserNameAlreadyExists($user_name)
{
	global $database;

	$query = $database->prepare("SELECT user_id FROM user WHERE user_name = :user_name");
	$query->execute(['user_name' => $user_name]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$res = $query->fetch();
	if (!empty($res))
		return (1);
	$query->closeCursor();
	return (0);
}

function checkCreateForm($mail, $user_name, $password, $password_confirm)
{
	$error = [];

	if (checkMailIsValid($mail))
		$error[] = ['mail', 'Please enter a valid mail'];
	if (checkUserNameIsValid($user_name))
		$error[] = ['user_name', 'Please enter a valid username'];
	if (checkPasswordIsValid($password, $password_confirm) == 1)
		$error[] = ['password', 'Please enter a password with at least 8 characters, one number and one letter'];
	if (checkPasswordIsValid($password, $password_confirm) == 2)
		$error[] = ['password_confirm', 'Please enter the same password'];
	if (checkMailAlreadyExists($mail))
		$error[] = ['mail', 'Mail already used'];
	if (checkUserNameAlreadyExists($user_name))
		$error[] = ['user_name', 'Username already used'];

	return ($error);
}

function checkMailPasswordDB($mail, $password)
{
	global $database;

	if (checkMailIsValid($mail) != 0)
		return (1);

	$query = $database->prepare("SELECT user_id FROM user WHERE user_mail = :mail AND user_password = :password");
	$query->execute(['mail' => $mail, 'password' => md5($password)]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$res = $query->fetch();
	$query->closeCursor();
	if (empty($res))
		return (2);
	return (0);
}

function checkUserInformation($mail, $password)
{
	$error = [];

	if (checkMailPasswordDB($mail, $password) == 1)
		$error[] = ['mail', 'Please enter a valid mail'];
	else
	{
		if (checkMailPasswordDB($mail, $password) == 2)
			$error[] = ['password', 'Mail or password invalid'];
		else if (checkIfUserConfirmed($mail) == 1)
			$error[] = ['password', 'Account not confirmed. Please click the link in the mail we sent'];
	}
	return ($error);
}

function checkIfUserConfirmed($mail)
{
	global $database;

	$query = $database->prepare("SELECT user_confirm FROM user WHERE user_mail = :mail");
	$query->execute(['mail' => $mail]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$res = $query->fetch()['user_confirm'];
	$query->closeCursor();
	if (!empty($res))
		return (1);
	return (0);
}

function checkRecuperationMail($mail)
{
	$error = [];

	if (checkMailIsValid($mail) != 0)
		$error[] = ['send_mail', 'Please enter a valid mail'];
	else if (checkMailAlreadyExists($mail) == 0)
		$error[] = ['send_mail', 'We cannnot find your mail in our database !'];
	return ($error);
}

function checkUserId($user_id)
{
	global $database;

	$query = $database->prepare("SELECT user_id FROM user WHERE user_id = :user_id");
	$query->execute(['user_id' => $user_id]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$data = $query->fetch();
	if (empty($data))
		return (1);
	return (0);
}

function deleteToken()
{
	setcookie('token', "", time() - 10, '/');
}

function checkToken()
{
	global $database;

	if (!isset($_COOKIE['token']))
		return (1);
	$token = json_decode($_COOKIE['token']);
	$query = $database->prepare("SELECT user_id FROM user WHERE user_id = :user_id AND user_mail = :user_mail");
	$query->execute(['user_id' => $token->user_id, 'user_mail' => $token->user_mail]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$res = $query->fetch();
	if (empty($res))
	{
		deleteToken();
		return (2);
	}
	return (0);
}

?>