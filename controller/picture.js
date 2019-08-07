/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   picture.js                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/07/18 06:36:48 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 20:53:22 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function deletePic(pic_id)
{
	promisedRequest
	.get("../model/process.php", { action: 'delete_pic', 'pic_id': pic_id })
	.then((response) => createAlert(response, "ok", () => location.href = "?view=home"))
	.catch((response) => createAlert(response, "ok", () => location.href = "?view=login"))
}