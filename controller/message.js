/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   message.js                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/07/29 16:01:31 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 00:06:38 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function fillError(id, errorMessage)
{
	const elem = document.getElementById(id);
	const errorFormDiv = document.createElement("div");

	errorFormDiv.id = "error";
	errorFormDiv.innerHTML = errorMessage;
	elem.parentNode.insertBefore(errorFormDiv, elem.nextSibling);
}

function resetErrorForm()
{
	const errorForm = document.querySelectorAll("#error");

	for (let i = 0; i < errorForm.length; i++)
		errorForm[i].parentNode.removeChild(errorForm[i]);
}

function checkIfAlertIsOn()
{
	if (document.getElementById("alert-container"))
		return (1);
	return (0);
}

function createAlert(message, buttonText = 'ok', callback = () => {})
{
	const container = document.createElement("div");
	const alertDiv = document.createElement("div");
	const messageDiv = document.createElement("div");
	const button = document.createElement("button");

	container.id = "alert-container";
	alertDiv.id = "alert";
	messageDiv.id = "message";
	messageDiv.innerHTML = message;
	button.innerHTML = buttonText;
	document.body.appendChild(container);
	container.appendChild(alertDiv);
	alertDiv.appendChild(messageDiv);
	alertDiv.appendChild(button);

	button.addEventListener('click', function (){
		document.body.removeChild(container);
		callback();
	});
}