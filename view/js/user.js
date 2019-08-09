/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   user.js                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mdalil <mdalil@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/05 03:08:04 by mayday            #+#    #+#             */
/*   Updated: 2019/08/09 02:37:54 by mdalil           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function genUserFeed(user_id)
{
	getPicturesFromDB(offset, user_id)
		.then((pic) => {
			pic.forEach((p) => generatePicture(p));
		})
		.catch((err) => {
		});
}

function createUserView(params)
{
	const user_id = params.get("user_id");

	genUserFeed(user_id);
	window.addEventListener("scroll", () => checkScroll(() => genUserFeed(user_id)));
}