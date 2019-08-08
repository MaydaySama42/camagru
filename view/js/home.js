/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   home.js                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mdalil <mdalil@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/03 23:51:53 by mayday            #+#    #+#             */
/*   Updated: 2019/08/08 22:56:52 by mdalil           ###   ########.fr       */
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