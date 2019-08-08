/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   generateView.js                                    :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mdalil <mdalil@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/03 23:53:47 by mayday            #+#    #+#             */
/*   Updated: 2019/08/08 23:09:43 by mdalil           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function generateForm(formList)
{
	const form = document.createElement("form");

	formList.forEach((formElem) => {
		const input = document.createElement("input");
		const comment = document.createElement("div");

		if ('id' in formElem)
			input.name = formElem.id;
		if ('id' in formElem)
			input.id = formElem.id;
		if ('type' in formElem)
			input.type = formElem.type;
		if ('value' in formElem)
			input.value = formElem.value;
		if ('onclick' in formElem)
			input.setAttribute("onclick", formElem.onclick);
		if ('text' in formElem)
			comment.innerText = formElem.text;
		
		comment.id = "comment";
		comment.style = "text-align: center;"
		if (formElem.type == "hidden")
			form.appendChild(input);
		else
		{
			comment.appendChild(input);
			form.appendChild(comment);
		}
	});
	return (form);
}

function getParams()
{
	const url = new URL(location);
	const param = new URLSearchParams(url.search);

	return (param);
}

function deleteParams(params)
{
	params.forEach((v, k) => params.delete(k));
}

function manageView()
{
	const params = getParams();
	feed.innerHTML = "";
	generateHeader();

	switch (params.get("view"))
	{
		case "home":
			createHomeView();
			break;
		case "login":
			createLoginView();
			break;
		case "create":
			createCreateView();
			break;
		case "montage":
			createMontageView();
			break;
		case "user":
			createUserView(params);
			break;
		case "pic":
			createPicView(params);
			break;
		case "admin":
			createAdminView();
			break;
		case "confirm":
			createConfirmView(params);
			break;
		case "recup":
			createRecuperationMailView();
			break;
		case "pass":
			createRecuperationPasswordView(params);
			break;
		case "hoome":
			document.getElementsByTagName("body")[0].innerHTML += `<img id="nothin" src="../resources/img/nothing.jpg">`;
			break;
		default:
			createHomeView();
			break;
	}
}

manageView();