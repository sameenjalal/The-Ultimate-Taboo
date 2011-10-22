import urllib, urllib2, pprint, re, md5, textmining, math, os, time
from Soup import BeautifulSoup, Comment

try:
	import json
except:
	import simplejson as json


#Pretty prints an array sorta like print_r in PHP
def print_r(obj):
	print pprint.pformat(obj, 4)

#This function gets the HTML content on a URL. It passes along header parameters to simulate an actual browser.
# FFFFFFFUUUUUUUUUUUU IMDB!
def get_html(url):
	default_headers = {
			'User-Agent': 'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10'
			#'Accept': 'application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
			#'Accept-Charset': 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
			#'Accept-Encoding': 'gzip,deflate,sdch',
			#'Accept-Language': 'en-US,en;q=0.8',
			#'Cache-Control': 'max-age=0',
			#'Connection': 'keep-alive'
			}
	req = urllib2.Request(url, headers=default_headers)
	try:
		response = urllib2.urlopen(req).read()
		return response

	except urllib2.HTTPError, err:
		print '------Error occurred: url: ', url , '  error: ',  err
		return ''

	except:
		print '------Error occurred: url: ', url
		return ''

# Returns the URLs from a Google Search for the specified query
def google_search_urls(query, num):
	rv = []
	for i in xrange(0, num, 8):
		rv += google_search_urls_helper(query, i)

	return rv

def google_search_urls_helper(query, start):
	google_url = 'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=8&start='+str(start)+'&'+urllib.urlencode({'q':query})
	results_json = get_html(google_url) 
	results_obj = json.loads(results_json)

	print results_obj

	if not results_json:
		return []
	if not results_obj:
		return []
	if not results_obj['responseData']:
		return []
	if not results_obj.has_key('responseData'):
		return []
	if not results_obj['responseData']['results']:
		return []
	if not results_obj['responseData'].has_key('results'):
		return []

	search_results_list = results_obj['responseData']['results']

	rv = []

	for result in search_results_list:
		rv.append(result['url'])

	return rv



#Fetches the HTML contents for a list of URLs
def fetch_html_list(url_list):
	file_list = []
	rv_list = [] 
	for url in url_list:
		rv_list.append(fetch_html(url, file_list)+"\n")
		time.sleep(1)
	
	return ''.join(rv_list), file_list

def textify(url):
	return md5.md5(url).hexdigest()[:10]

#Fetches the HTML for a single URL. Strips away all the script tags and the meta tags. Returns only terminal text.
def fetch_html(url, file_list):
	html = strip_html(get_html(url))
	s = 'query/'+textify(url)
	file_list.append(s)
	open(s, 'w').write(html.encode('utf-8'))
	return html


#This function strips all the html tags from a string
def strip_html(string):
	soup_doc = BeautifulSoup(string)

	#Remove Comments
	comments = soup_doc.findAll(text=lambda text:isinstance(text, Comment))
	[comment.extract() for comment in comments]

	#Remove unwanted tags
	unwanted_tags = soup_doc.findAll(['script', 'meta', 'style'])
	[unwanted_tag.extract() for unwanted_tag in unwanted_tags]

	return ''.join(soup_doc.findAll(text=lambda x: x))

def mine_files(file_list,word):
	data_raw = []
	data_send = []
	tdm = textmining.TermDocumentMatrix()
	if len(word) > 1:
		temp = word.split(' ')
		wordTemp = temp[0]
	else:
		wordTemp = word
	for i in range(0,len(file_list)):
		spot = 0
		data_raw = open(file_list[i]).read()
		r = re.compile('')
		data_raw = r.split(data_raw)
		spot = 0
		for y in range(0,len(data_raw)):
			if data_raw[y]==wordTemp:
				spot = y
			elif abs(y-spot)<300:

				data_send+=data_raw[y]
			
		tdm.add_doc(''.join(data_send))

	rows =  tdm.rows(cutoff=1)
	pos = []
	freq =[]
	count = 0
	for row in rows:
		if count ==0:
			pos = row
			count +=1
		else: 
			for r in range(0,len(row)):
				
				if len(freq)==r:
					freq.append(row[r])
				else:
					freq[r] += row[r]




		
	


#	freq_word = [(counts[0][0], word) for (word, counts) in textmining.dictionary.items()]
#	freq_word.sort(reverse=True)
#	print '\ndictionary_example 1\n'
#	count = 0
#	for freq, word in freq_word[:]:
#		for tup in textmining.dictionary[word]:
#			if(tup[1] in ['aj0','ajc','ajs','at0','av0','avp','avq','cjc','cjs'] and float(tup[0])/freq>.6 or word in textmining.stopwords):
#				break

#tup[1] in ['np0','nn1','nn0','nn2','vbz'] and float(tup[0])/freq>.9 and
#
#			if( freq > 100000):
#				print word, freq, tup[0], float(tup[0])/freq
#				break

	text = '';
	for i in range(0,len(file_list)):
		text = text + open(file_list[i]).read()
#		os.remove(file_list[i])
	words = textmining.simple_tokenize(text)
	bigrams = textmining.bigram_collocations(words)
	results = []
	for bigram in bigrams[:15]:
		results.append(' '.join(bigram))


	

	single = {}		
			
	for ind in range(0,len(freq)):
		if pos[ind] in textmining.stopwords:
			freq[ind] = 0
		for res in results:
			if pos[ind] in res:
				freq[ind] = 0
		single[-1*freq[ind]] = pos[ind]	




	single_end = single.items()	
	for q in range(0,40):
		if q >= len(single_end):
			continue
		results.append(single_end[q][1])

	sorted(results, key=lambda x: google_search_count(x +' '+ word), reverse=True)
		
	return results

def google_search_count(query):
	time.sleep(0.1)
	google_url = 'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=8&'+urllib.urlencode({'q':query})
	results_json = get_html(google_url) 

	if not results_json:
		return 0

	results_obj = json.loads(results_json)

	if not results_obj:
		return 0

	try:
		if not results_obj.has_key('responseData'):
			return 0
		if not results_obj['responseData'].has_key('cursor'):
			return 0
		if not results_obj['responseData']['cursor'].has_key('estimatedResultCount'):
			return 0
		return results_obj['responseData']['cursor']['estimatedResultCount']
	except:
		return 0




NUM_RESULTS = 8
def generate_taboo(word):
	search_urls = google_search_urls(word, NUM_RESULTS)
	file_str, file_list = fetch_html_list(search_urls)
	return mine_files(file_list,word)

#word = "indiana jones"

#print generate_taboo(word)

#print mine_files(['query/a61ac52b32', 'query/0c7b543f48', 'query/466eeca594', 'query/7455b9b734', 'query/b19c2beda9', 'query/dddefdf95a', 'query/c13d8ccf65', 'query/26907d4871', 'query/8b536c54ff', 'query/a7fa48f835', 'query/46bce9fe60', 'query/7c6d947621', 'query/60b6328681', 'query/eaae84aa24', 'query/ecab1adcec', 'query/a9e383ab5f', 'query/81ef7f8575', 'query/13280cfc0e', 'query/e9bc8cb49c', 'query/7547936cff', 'query/b648e3fa0a', 'query/eea76bd4e0', 'query/5e9929fdb0', 'query/2030acd058'],word)

