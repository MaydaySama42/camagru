/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   comment.js                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/07/15 04:36:48 by mdalil            #+#    #+#             */
/*   Updated: 2019/08/05 22:35:39 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function submitComment(form_elem)
{
	const form = new FormData(form_elem);
	const pic_id = form.get("pic_id");
	const com = form.get("comment_text").trim();

	if (com == "")
	{
		createAlert("Cant post empty comments !", "ok", () => {});
		return ;
	}
	promisedRequest
		.post("../model/process.php", { 'action': 'add_comment'}, form)
		.then((response) => {
			generateComments(response, document.querySelector(`#commentbox[data-pic-id="${pic_id}"]`), pic_id);
		})
		.catch((response) => {
			createAlert(response, "ok", () => location.href = "?view=login");
		});
}

document.onkeypress = function(e) {
	var key = e.charCode || e.keyCode || 0;     
	if (key == 13)
	  e.preventDefault();
}