import time
import http.client
import sched
import logging
import logging.handlers
import json

addrmap = {
    't_in': '28b4f91f07000048',
    't_out': '28ffa45f21170379'
}

def setup_logger():
    logHandler = logging.handlers.TimedRotatingFileHandler('.roomtemp/roomtemp.log', when='midnight')
    formatter = logging.Formatter('[%(asctime)s] [%(levelname).4s] %(message)s', "%Y-%m-%dT%H:%M:%S")
    logHandler.setFormatter(formatter)

    logger = logging.getLogger()
    logger.addHandler(logHandler)
    logger.setLevel(logging.INFO)

    logger.info("Started new logging session")

def read_temp():
    data = json.load(open('/usr/share/owreader/readout.json'))
    temps = {'t_in': 85.0, 't_out': 85.0}
    if addrmap['t_in'] in data:
        temps['t_in'] = round(data[addrmap['t_in']]['value'], 1)
    
    if addrmap['t_out'] in data:
        temps['t_out'] = round(data[addrmap['t_out']]['value'], 1)

    return temps

def update_thingspeak():
    temperatures = read_temp()

    # 85.0 means there were problems with reading temperature,
    # retry readout because there is no point in sending incorrect data
    while temperatures['t_in'] == 85.0 or temperatures['t_out'] == 85.0:
        temperatures = read_temp()
        time.sleep(1)

    conn = http.client.HTTPSConnection('api.thingspeak.com')
    upd_url = "/update?api_key=KEYWASCUT&field1=" + str(temperatures['t_in']) + "&field2=" + str(temperatures['t_out']) 
    conn.request("GET", upd_url)
    http_response = conn.getresponse()
    if http_response.status == 200:
        data = http_response.read()
        if int(data) != 0:
            logging.info("Updated channel feed with (%s, %s)", str(temperatures['t_in']), str(temperatures['t_out']))
        else:
            logging.error("ThingSpeak couldn't update the channel (0 returned)")
    else:
        logging.error("Request failed, recieved status other than 200 OK.")

setup_logger()

print("Running RoomTemp v1.0")

s = sched.scheduler(time.time, time.sleep)
def schedule_update(sc):
    s.enter(60, 1, schedule_update, (sc,))
    try:
        update_thingspeak()
    except Exception as e:
        logging.critical("Exception: %s", str(e))

s.enter(1, 1, schedule_update, (s,))
s.run()
