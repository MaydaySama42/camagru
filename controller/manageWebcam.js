/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   manageWebcam.js                                    :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mdalil <mdalil@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/04 17:05:52 by mayday            #+#    #+#             */
/*   Updated: 2019/08/08 22:50:10 by mdalil           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

class WebcamManager {jj
	constructor() {
		this.stream = null
		this.loading = null
	}

	start() {
		if (this.stream)
			throw new Error("Camagru - Stream has already been set !");
		if (!navigator.mediaDevices)
			throw new Error("Camagru - No webcam detected !");
		this.loading = navigator.mediaDevices
			.getUserMedia({ video: true })
			.then((stream) => {
				this.stream = stream;
				return this.stream;
			});
	}

	stop() {
		if (!this.stream)
			throw new Error("Camagru - Stream has not been initialized !");
		this.stream.getVideoTracks()[0].stop();
		this.stream = null;
	}
	
}

let webcam = null;
