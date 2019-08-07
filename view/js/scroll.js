/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   scroll.js                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/05 22:29:03 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 00:27:23 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

let offset = 0;

function checkScroll(callback)
{
	if (window.pageYOffset + window.innerHeight >= document.documentElement.scrollHeight)
	{
		offset += 5;
		callback();
	}
}