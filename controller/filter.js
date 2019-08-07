/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   filter.js                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/05 02:36:55 by mayday            #+#    #+#             */
/*   Updated: 2019/08/05 02:37:21 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function createFilterImg()
{
	const filter = document.createElement("img");
	const videoContainer = document.getElementById("video-container");

	filter.id = "filter";
	videoContainer.appendChild(filter);
	return (filter);
}

function selectFilter(evt)
{
	if (checkUserPicIsValid() == 1)
		return ;
	const filter = document.getElementById("filter") || createFilterImg();
	const filterChose = document.getElementById("filter-id");
	const filterSelected = evt.currentTarget;
	const filtersArray = Array.from(document.querySelectorAll(".filter-img"));

	filterSelected.classList.add("filter-selected");
	filter.src = filterSelected.src;
	filterChose.value = filterSelected.id;

	filtersArray.forEach((filt) => {
		if (filt != filterSelected)
			filt.classList.remove("filter-selected");
	});
	enableTakePicButton();
}

function getFiltersFromDB()
{
	return promisedRequest
			.get("../model/process.php", { 'action': 'get_filter'})
			.then((response) => response)
			.catch((err) => console.log(err));
}

function generateFilters()
{
	const filterBar = document.createElement("div");

	filterBar.id = "filter-bar";
	getFiltersFromDB()
		.then((filters) => {
			filters.forEach((f) => {
				let filterImg = document.createElement("img");
				let filterContain = document.createElement("div");

				filterContain.id = "filter-contain";
				filterImg.classList = "filter-img";
				filterImg.id = f.id;
				filterImg.src = f.path;
				filterImg.addEventListener("click", selectFilter);
				filterContain.appendChild(filterImg);
				filterBar.appendChild(filterContain);
			});
		});
	return (filterBar);
}