/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   generatePicture.js                                 :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/02 00:22:52 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 21:03:23 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function getPicturesFromDB(offset = 0, user_id = -1, pic_id = -1)
{
	return promisedRequest
		.get("../model/process.php", { 'action': 'get_pictures', user_id, offset, pic_id })
		.then((obj) => obj)
		.catch((err) => createAlert(`An error occured: ${err}`, "ok", () => location.href = "?view=home"));
}

function generateLikeBar(reactions, likebar, pic_id)
{
	let i = 1;

	likebar.innerHTML = "";
	Object.keys(reactions).forEach((reac) => {
		const form = document.createElement("form");
		const likebox = document.createElement("div");
		const button = document.createElement("input");
		const span = document.createElement("span");
		const input_hidden = document.createElement("input");
		const reaction_type = document.createElement("input");

		likebox.id = "likebox";
		button.type = "button";
		button.value = reac;
		button.setAttribute("onclick", `submitReaction(this.form)`);
		input_hidden.type = "hidden";
		input_hidden.name = "pic_id";
		input_hidden.value = pic_id;
		reaction_type.type = "hidden";
		reaction_type.name = "reaction_type";
		reaction_type.value = i++;

		span.innerHTML = reactions[reac];

		form.appendChild(button);
		form.appendChild(reaction_type);
		form.appendChild(input_hidden);
		form.appendChild(span);
		likebox.appendChild(form);
		likebar.appendChild(likebox);
	});
	
}

function addCommentInput(pic_id)
{
	const comment = document.createElement("div");
	const form = document.createElement("form");
	const input_text = document.createElement("input");
	const input_button = document.createElement("input");
	const input_hidden = document.createElement("input");

	comment.id = "comment";
	input_text.type = "text";
	input_text.name = "comment_text";
	input_hidden.type = "hidden";
	input_hidden.name = "pic_id";
	input_hidden.value = pic_id;
	input_button.type = "button";
	input_button.value = "send";
	input_button.setAttribute("onclick", "submitComment(this.form)");

	form.appendChild(input_text);
	form.appendChild(input_hidden);
	form.appendChild(input_button);
	comment.appendChild(form);
	return (comment);
}

function generateComments(comments, commentbox, pic_id)
{
	commentbox.innerHTML = "";	
	comments.forEach((com) => {
		let comment = document.createElement("div");
		let span = document.createElement("span");

		comment.id = "comment";
		span.innerHTML = `<a href="?view=user&user_id=${com.user_id}">${com.user_name}</a>`;
		comment.appendChild(span);
		comment.innerHTML += com.comment_text;
		commentbox.appendChild(comment);
	});
	commentbox.appendChild(addCommentInput(pic_id));
}

function addDeleteButton(pic_id)
{
	let commentbox = document.createElement("div");
	let comment = document.createElement("div");

	commentbox.id = "commentbox";
	comment.id = "comment";
	comment.innerHTML = `<input type="button" class="delete" value="delete pic" onclick="deletePic(${pic_id})">`;
	commentbox.appendChild(comment);
	return (commentbox);
}

function generatePicture(p) {
	const token = getToken();
	const feed = document.getElementById("feed");
	const element = document.createElement("div");
	const userpseudo = document.createElement("div");
	const picture = document.createElement("div");
	const likebar = document.createElement("div");
	const commentbox = document.createElement("div");

	element.id = "element";

	userpseudo.id = "userpseudo";
	userpseudo.innerHTML = `<a href="?view=user&user_id=${p.user_id}">${p.user_name}</a>`;
	picture.id = "picture";
	picture.innerHTML = `<a href="?view=pic&pic_id=${p.pic_id}"><img src="${p.pic_path}"/></a>`;
	likebar.id = "likebar";
	likebar.setAttribute("data-pic-id", p.pic_id);
	commentbox.id = "commentbox";
	commentbox.setAttribute("data-pic-id", p.pic_id);
	// generate likebar
	generateLikeBar(p.reactions, likebar, p.pic_id);
	// generate comments
	generateComments(p.comments, commentbox, p.pic_id);

	element.appendChild(userpseudo);
	element.appendChild(picture);
	element.appendChild(likebar);
	element.appendChild(commentbox);
	if (token)
	{
		if (token.user_id == p.user_id)
			element.appendChild(addDeleteButton(p.pic_id));
	}
	feed.appendChild(element);
}