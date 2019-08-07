<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   comment.php                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/01 22:52:38 by mayday            #+#    #+#             */
/*   Updated: 2019/08/01 22:52:48 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("../config/database.php");
require_once("user_check.php");

function sendNotificationNewComment($pic_id, $actual_user_id)
{
	global $database;

	$query = $database->prepare("SELECT user_id, user_mail, notification FROM user WHERE user_id = (SELECT user_id FROM picture WHERE pic_id = :pic_id)");
	$query->execute(['pic_id' => $pic_id]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$user = $query->fetch();
	$query->closeCursor();

	if ($user['user_id'] != $actual_user_id && $user['notification'] == 1)
	{
		mail($user['user_mail'],
			'you got a new comment',
			"hi, camagru team here !\n\n
			you got a new comment on your picture:\n\n
			http://localhost/camagru/view/?view=pic&pic_id=" . $pic_id . "\n\n
			hope we'll see you soon !\n\n
			camagru team",
			'From: team@camagru.com' . "\r\n" . 'Reply-To: team@camagru.com' . "\r\n");
	}
}

function addComment($pic_id, $comment_text)
{
	global $database;

	if (checkToken() != 0)
		return (sendResponse("Please log in to comment !", 400));
	$comment_text = trim($comment_text);
	if (empty($comment_text))
		return (sendResponse("Cant post empty comments !", 400));
	$data = [
		'user_id' => json_decode($_COOKIE['token'])->user_id,
		'comment' => $comment_text,
		'pic_id' => $pic_id
	];
	$query = $database->prepare("INSERT INTO comment (user_id, comment_text, pic_id) VALUES (:user_id, :comment, :pic_id)");
	$query->execute($data);
	$query->closeCursor();

	sendNotificationNewComment($data['pic_id'], $data['user_id']);
	return (0);
}

function getCommentsFromDB($pic_id)
{
	global $database;

	$comments = [];
	$query = $database->prepare("SELECT comment_text, user_id FROM comment WHERE pic_id = :pic_id");
	$query->execute(['pic_id' => $pic_id]);
	$query->setFetchMode(PDO::FETCH_ASSOC);

	while ($comment = $query->fetch())
		$comments[] = [
			'user_id' => $comment['user_id'],
			'user_name' => getUserName($comment['user_id']),
			'comment_text' => $comment['comment_text']
		];
	$query->closeCursor();
	return ($comments);
}

?>