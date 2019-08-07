/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   header.js                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/02 22:58:50 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 16:43:52 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function generateHeader()
{
	let nav = document.getElementsByTagName("nav")[0];
	let container = document.createElement("div");
	let pic = document.createElement("div");
	let bar = document.createElement("div");
	let token = getToken();

	container.id = "container";
	pic.innerHTML = `<a href="?view=home"><img src="../resources/img/logo-camagru.png"/></a>`;
	bar.innerHTML = token
		? `<a href="?view=montage">take a picture</a> | <a href="?view=user&user_id=${token.user_id}">${token.user_name}</a> | <a href="?view=admin">config</a> | <label onclick="accountAction('delog_user', 0, () => location.href = '?view=home')">delog</label>`
		: `<a href="?view=login">login</a> | <a href="?view=create">sign up</a>`;
	container.appendChild(pic);
	container.appendChild(bar);
	nav.innerHTML = "";
	nav.appendChild(container);
}