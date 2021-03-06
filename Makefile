PLOVR = plovr-81ed862.jar

.PHONY: serve build lint qtgdal

all: serve

$(PLOVR):
	curl -S -L https://plovr.googlecode.com/files/plovr-81ed862.jar > $(PLOVR)

serve: $(PLOVR)
	java -jar $(PLOVR) serve standalone-debug.json plugin-debug.json

build: $(PLOVR) build/iiifviewer.js qtgdal

build/iiifviewer.js: build_dir $(PLOVR) src/iiifsource.js src/iiifviewer.js src/exports.js src/standalone.js plugin.json standalone.json
	java -jar $(PLOVR) build standalone.json > build/iiifviewer.js
	java -jar $(PLOVR) build plugin.json > build/ol-iiifviewer.js

build/ol3.js: build_dir
	curl -L  http://openlayers.org/en/v3.0.0/build/ol.js > build/ol3.js

qtgdal: build_dir src/examples/qtgdal.php build/iiifviewer.js build/ol3.js
	php src/examples/qtgdal.php > build/qtgdal.html
	php src/examples/qtgdal-webgl.php > build/qtgdal-webgl.html

lint:
	fixjsstyle --strict -r ./src
	gjslint --strict -r ./src

clean:
	rm -rf build

build_dir: 
	@mkdir -p build
