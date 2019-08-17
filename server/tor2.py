#用于rec

from tornado.web import RequestHandler, Application
from tornado.ioloop import IOLoop
from tornado.httpserver import HTTPServer
import requests
import base64
import json
from server.Distinguish_API.AipImageClassify import get_distinguish

def translation(path):
    data  = get_distinguish(path)
    return data


class result_handler(RequestHandler):
    def get(self):
        b64_data = self.get_argument("b64_data")
        picture_data = base64.b64decode(b64_data)
        with open("image1.jpg", "wb") as f:
            f.write(picture_data)
        result = translation("image1.jpg")
        result_word = result['result'][0]['keyword']
        print(result_word)
        print(result)
        data = {
            'result_word': result_word
        }



if __name__ == '__main__':
    app = Application(
        [
            (r'/upload', result_handler)
             ],
    )

    http_server = HTTPServer(app)
    http_server.listen(8001)
    IOLoop.current().start()
