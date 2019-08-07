/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   manageWebcam.js                                    :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/04 17:05:52 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 22:22:13 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

class WebcamManager {
	constructor() {
		this.stream = null
		this.loading = null
		this.start();
	}

	start() {
		if (this.stream)
			throw new Error("Stream has already been set !");
		this.loading = navigator.mediaDevices
			.getUserMedia({video: true, audio: true})
			.then((stream) => {
				this.stream = stream;
				return this.stream;
			});
	}

	stop() {
		if (!this.stream)
			throw new Error("Stream has not been initialized !");
		this.stream.getVideoTracks()[0].stop();
		this.stream = null;
	}
	
}

let webcam = null;
