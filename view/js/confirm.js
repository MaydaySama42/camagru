/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   confirm.js                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mdalil <mdalil@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/06 20:00:11 by mayday            #+#    #+#             */
/*   Updated: 2019/08/09 02:37:24 by mdalil           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function createConfirmView(params)
{
	const user_id = params.get("user_id");
	const confirm = params.get("confirm");

	promisedRequest
		.get("../model/process.php", { action: 'confirm_account', 'user_id': user_id, 'confirm': confirm })
		.then((response) => createAlert(response, "ok", () => location.href = "?view=login"))
		.catch((response) => createAlert(response, "ok", () => location.href = "?view=login"));
}