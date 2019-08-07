/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   reaction.js                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/07/18 00:06:42 by mayday            #+#    #+#             */
/*   Updated: 2019/08/05 20:14:14 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function submitReaction(form_elem)
{
	const form = new FormData(form_elem);
	const pic_id = form.get("pic_id");

	promisedRequest
		.post("../model/process.php", { 'action': 'add_reaction'}, form)
		.then((response) => {
			generateLikeBar(response, document.querySelector(`#likebar[data-pic-id="${pic_id}"]`), pic_id);
		})
		.catch((response) => {
			createAlert(response, "ok", () => location.href = "?view=login");
		});
}
