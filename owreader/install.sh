#!/bin/bash

cp bin/owreader /usr/bin
mkdir -p /usr/share/owreader
cp owreader.service /etc/systemd/system/
systemctl enable owreader.service
