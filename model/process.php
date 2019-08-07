<?php

/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   process.php                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mdalil <mdalil@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/06/16 19:41:47 by mdalil            #+#    #+#             */
/*   Updated: 2019/06/16 19:41:47 by mdalil           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("../config/database.php");
require_once("comment.php");
require_once("picture.php");
require_once("user.php");
require_once("user_recuperation.php");
require_once("user_change.php");

if(session_status() == PHP_SESSION_NONE)
	session_start();

function sendResponse($response, $code)
{
	echo json_encode($response);
	http_response_code($code);
	header("Access-Control-Allow-Origin: http://google.fr");
	header("Vary: Origin");
	return ($code == 200 ? 0 : 1);
}

if (!empty($_GET))
{
	foreach ($_GET as $key => $value)
		$_GET[$key] = htmlentities(strip_tags(trim($_GET[$key])), ENT_NOQUOTES);
	if (!empty($_POST))
	{
		foreach ($_POST as $key => $value)
			$_POST[$key] = htmlentities(strip_tags(trim($_POST[$key])), ENT_NOQUOTES);
	}
	switch($_GET['action'])
	{
		case 'create_user':
			createUser($_POST['mail'], $_POST['user_name'], $_POST['password'], $_POST['password_confirm']);
			break;
		case 'confirm_account':
			confirmUser($_GET['user_id'], $_GET['confirm']);
			break;
		case 'login_user':
			loginUser($_POST['mail'], $_POST['password']);
			break;
		case 'get_pictures':
			genPicturesArray($_GET['user_id'], $_GET['offset'], $_GET['pic_id']);
			break;
		case 'delete_pic':
			deletePic($_GET['pic_id']);
			break;
		case 'add_comment':
			if (addComment($_POST['pic_id'], $_POST['comment_text']) == 0)
				sendResponse(getCommentsFromDB($_POST['pic_id']), 200);
			break;
		case 'add_reaction':
			if (addReaction($_POST['pic_id'], $_POST['reaction_type']) == 0)
				sendResponse(getReactionsFromDB($_POST['pic_id']), 200);
			break;
		case 'delog_user':
			delogUser();
			break;
		case 'get_filter':
			getFiltersFromDB();
			break;
		case 'send_recuperation_mail':
			sendRecuperationMail($_POST['mail']);
			break;
		case 'send_new_password':
			sendNewPassword($_POST['user_id'], $_POST['confirm'], $_POST['password'], $_POST['password_confirm']);
			break;
		case 'change_mail':
			changeMail($_POST['mail']);
			break;
		case 'change_username':
			changeUserName($_POST['username']);
			break;
		case 'change_password':
			changePassword($_POST['password'], $_POST['password_confirm']);
			break;
		case 'change_notification':
			changeNotification();
			break;
		case 'get_admin':
			getUserValuesFromDB();
			break;
		case 'post_picture':
			addPic($_POST['filter-id'], $_POST['image']);
			break;
		
	}
}

?>