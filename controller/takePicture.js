/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   takePicture.js                                     :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mdalil <mdalil@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/04 18:41:54 by mayday            #+#    #+#             */
/*   Updated: 2019/08/09 02:37:09 by mdalil           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function checkUserPicIsValid()
{
	return (webcam.stream || document.getElementById("actual-element")) ? 0 : 1;
}

function checkIsFilterSelected()
{
	const filter = document.getElementById("filter");
	const filterChose = document.getElementById("filter-id");
	if (!filter || (filterChose.value < 0 && filterChose.value > 7))
		return (1);
	return (0);
}

function enableTakePicButton()
{
	const takePicButton = document.getElementById("take-pic");

	if (checkUserPicIsValid() == 0 && checkIsFilterSelected() == 0)
		takePicButton.disabled = false;
	return (0);
}

function fillImgReplacement()
{
	const replaceImg = document.createElement("img");

	replaceImg.id = "actual-element";
	return (replaceImg);
}

function changeFile(files)
{
	const videoContainer = document.getElementById("video-container");
	const filter = document.getElementById("filter");

	if (webcam.stream)
	{
		const video = document.getElementsByTagName("video")[0];
		webcam.stop();
		video.parentNode.removeChild(video);
	}
	if (files[0])
	{
		const replaceImg = document.getElementById("actual-element") || fillImgReplacement();
		const reader = new FileReader();

		reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(replaceImg);
		reader.readAsDataURL(files[0]);
		videoContainer.insertBefore(replaceImg, filter);
	}
}

function takePic()
{
	let pic = document.getElementById("actual-element");
	const canvas = document.createElement('canvas');
	let context;

	/*if (!webcam.stream)
		pic = pic.src;*/
	canvas.width = 640;
	canvas.height = 480;
	context = canvas.getContext('2d');
	context.drawImage(pic, 0, 0, canvas.width, canvas.height);
	return (canvas.toDataURL('image/png'));
}

function sendPic(htmlForm)
{
	const form = new FormData(htmlForm);

	form.append("image", takePic());
	promisedRequest
		.post("../model/process.php", { 'action': 'post_picture'}, form)
		.then((response) => {
			console.log(response);
			createAlert("Picture done !", "ok", () => location.href=`?view=pic&pic_id=${response}`);
		})
		.catch((response) => createAlert(response, "ok", () => location.reload(true)));
}