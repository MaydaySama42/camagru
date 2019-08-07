/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   pic.js                                             :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/06 00:03:40 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 03:12:22 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function genPicFeed(pic_id)
{
	getPicturesFromDB(offset, -1, pic_id)
		.then((pic) => {
			pic.forEach((p) => generatePicture(p));
		})
		.catch((err) => {
		});
}

function createPicView(params)
{
	const pic_id = params.get("pic_id");

	genPicFeed(pic_id);
}