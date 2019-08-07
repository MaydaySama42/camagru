/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   montage.js                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/04 15:44:01 by mayday            #+#    #+#             */
/*   Updated: 2019/08/05 22:49:05 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function generateMontageForm()
{
	const form = document.createElement("form");
	const file = document.createElement("input");
	const fileButton = document.createElement("input");
	const takePicButton = document.createElement("input");
	const filterChose = document.createElement("input");

	file.id = "img-replace";
	file.name = "img-replace";
	file.type = "file";
	file.setAttribute("onchange", "changeFile(this.files)");
	fileButton.setAttribute("onclick", `document.getElementById("img-replace").click()`);
	fileButton.value = "select file";
	fileButton.type = "button";
	takePicButton.id = "take-pic";
	takePicButton.value = "take pic";
	takePicButton.type = "button";
	takePicButton.disabled = true;
	takePicButton.setAttribute("onclick", `sendPic(this.form)`);
	filterChose.id = "filter-id";
	filterChose.name = "filter-id";
	filterChose.value = -1;
	filterChose.type = "hidden";

	form.appendChild(file);
	form.appendChild(fileButton);
	form.appendChild(takePicButton);
	form.appendChild(filterChose);
	form.setAttribute("enctype", "multipart/form-data");
	return (form);
}

function createMontageView()
{
	const feed = document.getElementById("feed");
	const element = document.createElement("div");
	const videoContainer = document.createElement("div");
	const choiceBar = document.createElement("div");
	const filterBar = generateFilters();
	const form = generateMontageForm();

	webcam = new WebcamManager();

	element.id = "element";
	element.style = "width: 90%;";
	videoContainer.id = "video-container";
	choiceBar.id = "choice-bar";
	filterBar.id = "filter-bar";
	
	webcam.loading
		.then((stream) => {
			const video = document.createElement("video");

			video.id = "actual-element";
			video.autoplay = "true";
			video.srcObject = stream;
			videoContainer.appendChild(video);
			
		})
		.catch((error) => {
			console.error(`Could not access camera: ${error.message}`);
			createAlert("Could not access camera. Please select a picture instead !");
			
		})

	choiceBar.appendChild(form);
	element.appendChild(videoContainer);
	element.appendChild(choiceBar);
	element.appendChild(filterBar);
	feed.appendChild(element);
}