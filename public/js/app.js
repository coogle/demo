
/**
 * Add commas to a number
 */
function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/**
 * Calculate the total votes
 */
function doTotalVotes()
{
	var tableNode = document.getElementById('votesTable');
	
	var colors = tableNode.getAttribute('data-colors').split(',');
	
	var total = 0;
	
	totalNode = document.getElementById('votesTotal');
	totalNode.innerHTML = 0;
	
	colors.forEach(function(color) {
		voteNode = document.getElementById('color-' + color);
		
		total = total + parseInt(voteNode.getAttribute('data-votes'));
	});
	
	totalNode.innerHTML = numberWithCommas(total);
}

/**
 * The callback used when we have successfully loaded a set of votes
 * 
 * @param color The color that we are processing
 * @param votes The number of votes we loaded
 * @param xmlHttp the XMLHttp request, in case we want to do something fancy
 */
function doLoadingSuccess(color, votes, xmlHttp)
{
	voteNode = document.getElementById('color-' + color);
	
	voteNode.innerHTML = numberWithCommas(votes);
	voteNode.setAttribute('data-votes', votes);
}

/**
 * The callback used when we have failed to load our AJAX request
 * @param color The color that we are processing
 * @param xmlHttp the XMLHttp request
 */
function doLoadingFailure(color, xmlHttp)
{
	alert("There was an error loading the votes");
}

/**
 * A callback called prior to loading the votes so we can do some UI work
 * @param color The color we are processing
 */
function doLoadingVotes(color)
{
	voteNode = document.getElementById('color-' + color);
	voteNode.innerHTML = '-';
}

/**
 * Called when a user clicks on a color to load the votes
 * @param color The color the user clicked on
 * @param success The callback for success
 * @param failure The callback for failure
 * @param loading The callback for loading
 */
function getVotesForColor(color, success, failure, loading)
{
	var xmlHttp;

	totalNode = document.getElementById('votesTotal');
	totalNode.innerHTML = '-';

	if(window.XMLHttpRequest) {
		xmlHttp = new XMLHttpRequest();
	} else {
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlHttp.onreadystatechange = function() {
		if(xmlHttp.readyState == 4) {
			switch(xmlHttp.status) {
				case 200:
					if(success) {
						success(color, JSON.parse(xmlHttp.responseText), xmlHttp);
					}
					break;
				default:
					if(failure) {
						failure(color, xmlHttp);
					}
					break;
			}
		}
	}
	
	xmlHttp.open("GET", "/votes?color=" + encodeURIComponent(color));
	
	if(loading) {
		loading(color);
	}
	
	xmlHttp.send();
}
