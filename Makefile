PLOVR = plovr-81ed862.jar

.PHONY: serve build lint

all: serve

$(PLOVR):
	curl https://plovr.googlecode.com/files/plovr-81ed862.jar > $(PLOVR)

serve: $(PLOVR)
	java -jar $(PLOVR) serve standalone-debug.json plugin-debug.json

build: $(PLOVR) build/iiifviewer.js qtgdal

build/iiifviewer.js: src/iiifsource.js src/iiifviewer.js
	@mkdir -p build
	java -jar $(PLOVR) build standalone.json > build/iiifviewer.js
	java -jar $(PLOVR) build plugin.json > build/ol-iiifviewer.js

qtgdal: src/examples/qtgdal.php build/iiifviewer.js
	php src/examples/qtgdal.php > build/qtgdal.html

lint:
	fixjsstyle --strict -r ./src
	gjslint --strict -r ./src

clean:
	rm -rf build