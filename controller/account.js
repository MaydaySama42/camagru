/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   account.js                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/07/18 06:36:48 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 20:04:40 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function getToken()
{
	try {
		return JSON.parse(decodeURIComponent(document.cookie.replace(/(?:(?:^|.*;\s*)token\s*\=\s*([^;]*).*$)|^.*$/, "$1")));
	}
	catch (e) {
		return ;
	}
}

function accountAction(action, form, success = () => location.href = "?view=login", fail = () => location.href = "?view=login")
{
	if (checkIfAlertIsOn() == 1)
		return ;
	promisedRequest
		.post("../model/process.php", { 'action': action }, form ? new FormData(form) : 0)
		.then((response) => createAlert(response, "ok", success))
		.catch((response) => {
			if (typeof response == "string")
				createAlert(response, "ok", fail);
			else
			{
				resetErrorForm();
				response.forEach((err) => {
					fillError(err[0], err[1])
				});
			}
		});
}
