<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   database.php                                       :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mdalil <mdalil@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/06/16 14:20:23 by mdalil            #+#    #+#             */
/*   Updated: 2019/06/16 14:20:30 by mdalil           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("setup.php");

$db["host"] = "127.0.0.1";
$db["port"] = '3306';
$db["user"] = "root";
$db["pwd"] = "root";
$db["dsn"] = 'mysql:host='.$db["host"].';port='.$db["port"].';';

try
{
	$database = new PDO($db["dsn"], $db["user"], $db["pwd"]);
	$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	createDatabase();
}
catch(Exception $e)
{
        echo 'Erreur : '.$e->getMessage().'<br />';
		echo 'N° : '.$e->getCode();
		sendResponse("Database error", 400);
}

?>