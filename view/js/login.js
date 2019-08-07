/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   login.js                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/03 23:51:08 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 21:20:42 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function createLoginView()
{
	const feed = document.getElementById("feed");
	const element = document.createElement("div");
	const commentbox = document.createElement("div");
	const form_list = [
		{id: "mail", type: "text", text: "Mail"},
		{id: "password", type: "password", text: "Password"},
		{id: "send", type: "button", value: "send", onclick: "accountAction('login_user', this.form, () => location.href = '?view=home', () => location.href = '?view=home')"}
	];
	const form = generateForm(form_list);

	element.id = "element";
	commentbox.id = "commentbox";

	
	commentbox.appendChild(form);
	commentbox.innerHTML += `<div id="comment"><a href="?view=recup" style="text-align: right;margin-bottom:10px;">forget password ?</a></div>`;
	element.appendChild(commentbox);
	
	feed.appendChild(element);
}