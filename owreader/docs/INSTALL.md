# OWReader
---
An application that reads one-wire devices and puts the readouts in a file.

### Components
This application consists of two parts, a application itself and a systemd service file.

### Installation
OWReader binary file should be copied to /usr/bin and a directory /usr/share/owreader should be created. Next owreader.service file should be copied to /etc/systemd/systems/. The last thing is to enable the service on boot by systemctl enable owreader.service and start it (systemctl start owreader.service).
