/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   create.js                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/04 02:22:10 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 00:16:10 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function createCreateView()
{
	const feed = document.getElementById("feed");
	const element = document.createElement("div");
	const commentbox = document.createElement("div");
	const form_list = [
		{id: "mail", type: "text", text: "Mail"},
		{id: "user_name", type: "text", text: "Username"},
		{id: "password", type: "password", text: "Password"},
		{id: "password_confirm", type: "password", text: "Confirm"},
		{id: "send", type: "button", value: "send", onclick: "accountAction('create_user', this.form, () => location.href = '?view=login', () => location.href = '?view=login')"}
	];
	const form = generateForm(form_list);

	feed.innerHTML = "";
	generateHeader();

	element.id = "element";
	commentbox.id = "commentbox";

	commentbox.appendChild(form);
	element.appendChild(commentbox);
	
	feed.appendChild(element);
}