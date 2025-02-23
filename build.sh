#!/bin/bash
docker build -f Dockerfile -t devniblcouk .
docker stop devniblcouk
docker rm devniblcouk
docker run -d --net='my-bridge' -v '/opt/dev.nibl.co.uk/var':'/var/www/html/var':'rw' --name=devniblcouk devniblcouk
