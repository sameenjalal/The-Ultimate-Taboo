import MySQLdb, parse_google as parse

try:
	import json
except:
	import simplejson as json

DB_HOST = 'mysql.vverma.net'
DB_USER = 'vverna'
DB_PASS = 'Verma123'
DB_NAME = 'taboo_generator'

init_easy = ['House MD', 'Lord of the Rings', 'Lamp', 'Trees', 'Jim Carrey', 'Jennifer Aniston', 'New York City', 'Harry Potter', 'Why so Serious', 'Clouds', 'Computer', 'Dartmouth', 'Luke Skywalker', 'Darth Vader', 'Mike The Situation', 'Snooki']

init_hard = ['Dungeons and Dragons', 'Neopets', 'Mia Hamm', 'Victoria Beckham', 'Zynga', 'The Dark Avenger', 'Kinect', 'Thats all folks', 'Elmer Fudd', 'Yahtzee', 'Sun Chips', 'AMP', 'New York Times']

init_dirty = ['Penis', 'Hermaphrodite', 'Strawberry Kiss', 'Anal', 'Freak in the Sheets', 'Brittany Spears', 'Asexual', 'Sex', 'One Night in Paris', 'Strip Poker']

db = MySQLdb.connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)

def store_word(word, associated, type=0):
	if isinstance(associated, list):
		associated = json.dumps(associated)

	c = db.cursor()

	c.execute('SELECT * FROM taboo_words  WHERE word=%s', [word]) 

	if(c.fetchall()):
		return False

	c.execute('INSERT INTO taboo_words (word, associated, type) VALUES(%s, %s, %s)', [word, associated, type]) 

	if(c.rowcount):
		return True

	print "wtf?"
	return False

for word in init_easy:
	associated = parse.generate_taboo(word)
	type = 0

	print store_word(word, associated, type)

for word in init_hard:
	associated = parse.generate_taboo(word)
	type = 1

	print store_word(word, associated, type)

for word in init_dirty:
	associated = parse.generate_taboo(word)
	type = 2

	print store_word(word, associated, type)
