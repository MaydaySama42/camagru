/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   home.js                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/03 23:51:53 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 21:56:44 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function genHomeFeed()
{
	getPicturesFromDB(offset)
	.then((pic) => {
		pic.forEach((p) => generatePicture(p));
	})
	.catch((err) => {
	});
}

function createHomeView()
{
	genHomeFeed();
	window.addEventListener("scroll", () => checkScroll(() => genHomeFeed()));
}