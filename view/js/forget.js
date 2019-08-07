/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   forget.js                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/06 21:14:13 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 21:49:16 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function createRecuperationMailView()
{
	const feed = document.getElementById("feed");
	const element = document.createElement("div");
	const commentbox = document.createElement("div");
	const form_list = [
		{id: "mail", type: "text", text: "Mail"},
		{id: "send_mail", type: "button", value: "send", onclick: "accountAction('send_recuperation_mail', this.form)"}
	];
	const form = generateForm(form_list);

	element.id = "element";
	commentbox.id = "commentbox";

	commentbox.appendChild(form);
	element.appendChild(commentbox);
	
	feed.appendChild(element);
}

function createRecuperationPasswordView(params)
{
	const feed = document.getElementById("feed");
	const element = document.createElement("div");
	const commentbox = document.createElement("div");
	const form_list = [
		{id: "password", type: "password", text: "Password"},
		{id: "password_confirm", type: "password", text: "Password confirm"},
		{id: "user_id", type: "hidden", value: params.get("user_id")},
		{id: "confirm", type: "hidden", value: params.get("confirm")},
		{id: "send_password", type: "button", value: "send", onclick: "accountAction('send_new_password', this.form)"}
	];
	const form = generateForm(form_list);

	element.id = "element";
	commentbox.id = "commentbox";

	commentbox.appendChild(form);
	element.appendChild(commentbox);
	
	feed.appendChild(element);
}