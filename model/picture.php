<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   picture.php                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/01 22:56:20 by mayday            #+#    #+#             */
/*   Updated: 2019/08/01 22:56:20 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("../config/database.php");
require_once("user_check.php");
require_once("reaction.php");
require_once("comment.php");

function checkPicId($pic_id)
{
	global $database;

	$query = $database->prepare("SELECT pic_id FROM picture WHERE pic_id = :pic_id");
	$query->execute(['pic_id' => $pic_id]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$data = $query->fetch();
	if (empty($data))
		return (1);
	return (0);
}

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{
	$cut = imagecreatetruecolor($src_w, $src_h); 
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
}

function checkPic($filter_id, $image)
{
	$error = "";

	if ($filter_id < 0 || $filter_id > 7)
		$error = 'Wrong filter !';
	else if (exif_imagetype($image) != IMAGETYPE_PNG && exif_imagetype($image) != IMAGETYPE_JPEG)
		$error = 'Image corrupted !';
	return ($error);
}

function returnImage($image)
{
	$image = str_replace('data:image/png;base64,', '', $image);
	$image = str_replace(' ', '+', $image);
	file_put_contents("./image_tmp.png", base64_decode($image));
	return (imagecreatefrompng("./image_tmp.png"));
}

function createPicInDB($user_id)
{
	global $database;

	$query = $database->prepare("INSERT INTO picture (user_id) VALUES (:user_id)");
	$query->execute(['user_id' => $user_id]);
	$pic_id = $database->lastInsertId();
	$query->closeCursor();
	return ($pic_id);
}
function addPic($filter_id, $image)
{
	global $database;

	if (checkToken() != 0)
		return (sendResponse("User not logged !", 400));
	$error = checkPic($filter_id, $image);
	if (!empty($error))
		return (sendResponse($error, 400));

	$user_id = json_decode($_COOKIE['token'])->user_id;
	$pic_id = createPicInDB($user_id);
	$user_image = returnImage($image);
	$filter = imagecreatefrompng("../resources/img/filter/filter" . $filter_id . ".png");
	imagecopymerge_alpha($user_image, $filter, 0, 0, 0, 0, 640, 480, 100);

	$user_path = "../resources/user-" . $user_id . "/";
	if (!is_dir($user_path))
		mkdir($user_path);
	$pic_path = $user_path . "pic" . $pic_id . "-" . $user_id . "-" . getdate()[0] . ".png";
	imagepng($user_image, $pic_path);
	unlink("./image_tmp.png");

	$query = $database->prepare("UPDATE picture SET pic_path = :pic_path WHERE pic_id = :pic_id");
	$query->execute(['pic_id' => $pic_id, 'pic_path' => $pic_path]);
	$query->closeCursor();
	return (sendResponse($pic_id, 200));
}

function deletePic($pic_id)
{
	global $database;

	if (checkToken() != 0)
		return (sendResponse("User not logged !", 400));
	$user_id = json_decode($_COOKIE['token'])->user_id;
	if (checkPicId($pic_id) || checkUserId($user_id))
		return (sendResponse("Bad data !", 400));

	$query = $database->prepare("SELECT pic_path FROM picture WHERE pic_id = :pic_id AND user_id = :user_id");
	$query->execute(['pic_id' => $pic_id, 'user_id' => $user_id]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$data = $query->fetch();
	$query->closeCursor();

	if (empty($data))
		return (sendResponse("Bad data !", 400));

	unlink($data['pic_path']);
	$query = $database->prepare("DELETE FROM comment WHERE pic_id = :pic_id");
	$query->execute(['pic_id' => $pic_id]);
	$query->closeCursor();
	$query = $database->prepare("DELETE FROM reactions WHERE pic_id = :pic_id");
	$query->execute(['pic_id' => $pic_id]);
	$query->closeCursor();
	$query = $database->prepare("DELETE FROM picture WHERE pic_id = :pic_id");
	$query->execute(['pic_id' => $pic_id]);
	$query->closeCursor();
	return (sendResponse("Picture deleted !", 200));
}

function genPicturesArray($user_id, $offset, $pic_id)
{
	global $database;

	if ($user_id != -1 && checkUserId($user_id) != 0)
		return (sendResponse("bad user id", 400));
	if ($pic_id != -1 && checkPicId($pic_id) != 0)
		return (sendResponse("bad pic_id", 400));

	$query_home = "SELECT pic_id, pic_path, pic_date, user_id FROM picture ORDER BY pic_date DESC LIMIT " . $offset . ", 5";
	$query_user = "SELECT pic_id, pic_path, pic_date, user_id FROM picture WHERE user_id = " . $user_id . " ORDER BY pic_date DESC LIMIT " . $offset . ", 5";
	$query_pic = "SELECT pic_id, pic_path, pic_date, user_id FROM picture WHERE pic_id = " . $pic_id . " ORDER BY pic_date DESC";
	if ($user_id != -1)
		$query_final = $query_user;
	else if ($pic_id != -1)
		$query_final = $query_pic;
	else
		$query_final = $query_home;

	$query_pictures = $database->prepare($query_final);
	$query_pictures->execute();
	$query_pictures->setFetchMode(PDO::FETCH_ASSOC);
	$data = [];
	while ($pic = $query_pictures->fetch())
	{
		$data[] = [
			'pic_id' => $pic['pic_id'],
			'pic_date' => $pic['pic_date'],
			'pic_path' => $pic['pic_path'],
			'user_id' => $pic['user_id'],
			'user_name' => getUserName($pic['user_id']),
			'comments' => getCommentsFromDB($pic['pic_id']),
			'reactions' => getReactionsFromDB($pic['pic_id'])
		];
	}
	$query_pictures->closeCursor();

	return (sendResponse($data, 200));
}

function getFiltersFromDB()
{
	global $database;

	$query_filters = $database->prepare("SELECT filter_id, filter_path FROM filter");
	$query_filters->execute();
	$query_filters->setFetchMode(PDO::FETCH_ASSOC);
	while ($filter = $query_filters->fetch())
	{
		$filters[] = [
			'id' => $filter['filter_id'] - 1,
			'path' => $filter['filter_path']
		];
	}
	$query_filters->closeCursor();
	return (sendResponse($filters, 200));
}

?>