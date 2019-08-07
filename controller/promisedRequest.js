/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   promisedRequest.js                                 :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/07/31 23:07:18 by mayday            #+#    #+#             */
/*   Updated: 2019/08/03 01:35:02 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function parseQueryObject(query)
{
	if (typeof query !== "object")
		throw Error("the given parameter is not an object");
	return Object.entries(query).reduce((a, [k, v]) => `${a?`${a}&`:``}${k}=${v}`, "");
}

function handleResponse(req)
{
	try {
		return JSON.parse(req.responseText);
	}
	catch (e) {
		return req.responseText;
	}
}

function newRequest(resolve, reject)
{
	const req = new XMLHttpRequest();

	req.onreadystatechange = () => {
		if(req.readyState == 4)
		{
			if (req.status == 200)
				resolve(handleResponse(req));
			else
				reject(handleResponse(req));
		}
	};
	return (req);
}

const promisedRequest = {
	get: (url, query = {}) => new Promise((resolve, reject) => {
		const req = newRequest(resolve, reject);
		let str;

		try {
			str = parseQueryObject(query);
		} catch (e) {
			reject(e);
		}
		req.open("GET", `${url}${str?`?${str}`:''}`, true);
		req.send();
	}),
	post: (url, query = {}, form) => new Promise((resolve, reject) => {
		const req = newRequest(resolve, reject);
		let str;

		try {
			str = parseQueryObject(query);
		} catch (e) {
			reject(e);
		}
		req.open("POST", `${url}${str?`?${str}`:''}`, true);
		req.send(form);
	})
};
