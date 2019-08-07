<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   reaction.php                                       :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/01 22:57:23 by mayday            #+#    #+#             */
/*   Updated: 2019/08/01 22:57:24 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("../config/database.php");

function addReaction($pic_id, $reaction_type)
{
	global $database;

	if (checkToken() != 0)
		return (sendResponse("User not logged !", 400));
	$user_id = json_decode($_COOKIE['token'])->user_id;
	if (checkPicId($pic_id) || checkUserId($user_id))
		return (sendResponse("bad id !", 400));

	$query = $database->prepare("SELECT reaction_id, reaction_type FROM reactions WHERE pic_id = :pic_id AND user_id = :user_id");
	$query->execute(['pic_id' => $pic_id, 'user_id' => $user_id]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$data = $query->fetch();
	$query->closeCursor();

	$query_create_reac = "INSERT INTO reactions (reaction_type, pic_id, user_id) VALUES (" . $reaction_type . ", " . $pic_id . ", " . $user_id . ")";
	$query_delete_reac = "DELETE FROM reactions WHERE reaction_id = " . $data['reaction_id'];
	$query_update_reac = "UPDATE reactions SET reaction_type = " . $reaction_type . " WHERE reaction_id = " . $data['reaction_id'];
	if (empty($data))
		$query_reaction = $query_create_reac;
	else
	{
		if ($reaction_type == $data['reaction_type'])
			$query_reaction = $query_delete_reac;
		else
			$query_reaction = $query_update_reac;
	}
	$query = $database->prepare($query_reaction);
	$query->execute();
	$query->closeCursor();
	return (0);
}

function getSumReaction($data, $reaction_type)
{
	$count = 0;

	foreach ($data as $reaction)
	{
		$add = $reaction['reaction_type'] == $reaction_type ? 1 : 0;
		$count += $add;
	}
		
	return ($count);
}

function getReactionsFromDB($pic_id)
{
	global $database;

	$query_reaction = $database->prepare("SELECT reaction_id, reaction_type FROM reactions WHERE pic_id = :pic_id");
	$query_reaction->execute(['pic_id' => $pic_id]);
	$query_reaction->setFetchMode(PDO::FETCH_ASSOC);
	$data[] = $query_reaction->fetch();
	$reactions = [
		'like' => getSumReaction($data, 1),
		'happy' => getSumReaction($data, 2),
		'wouah' => getSumReaction($data, 3),
		'haha' => getSumReaction($data, 4)
	];
	$query_reaction->closeCursor();

	return ($reactions);
}
?>