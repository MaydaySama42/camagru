/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   admin.js                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/06 00:15:35 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 17:50:39 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function getValuesFromDB()
{
	return promisedRequest
		.get("../model/process.php", { action: 'get_admin' })
		.then((response) => {
			document.getElementById("mail").value = response.user_mail;
			document.getElementById("username").value = response.user_name;
			document.getElementById("send_notification").value = `${response.notification == 1 ? `disable` : `enable`} notification`;
		})
		.catch((response) => createAlert(response, "ok", () => location.href = "?view=login"));
}

function createAdminView()
{
	const feed = document.getElementById("feed");
	const element = document.createElement("div");
	const commentbox = document.createElement("div");
	getValuesFromDB();
	const form = {
		'mail': generateForm([
		{id: "mail", type: "text", text: "Mail"},
		{id: "send_mail", type: "button", value: "send", onclick: "accountAction('change_mail', this.form)"}
		]),
		'username': generateForm([
		{id: "username", type: "text", text: "Username"},
		{id: "send_username", type: "button", value: "send", onclick: "accountAction('change_username', this.form)"}
		]),
		'password': generateForm([
		{id: "password", type: "password", text: "Password"},
		{id: "password_confirm", type: "password", text: "Password Confirm"},
		{id: "send_password", type: "button", value: "send", onclick: "accountAction('change_password', this.form)"}
		]),
		'notification': generateForm([
		{id: "send_notification", type: "button", onclick: "accountAction('change_notification', this.form, () => location.reload(true), () => location.href = '?view=login')"}
		])
	};

	element.id = "element";
	commentbox.id = "commentbox";

	Object.keys(form).forEach((form_elem) => commentbox.appendChild(form[form_elem]));
	element.appendChild(commentbox);
	
	feed.appendChild(element);
}