#用于rec

from tornado.web import RequestHandler, Application
from tornado.ioloop import IOLoop
from tornado.httpserver import HTTPServer
import requests
import base64

def translation(path):
    return 1


class result_handler(RequestHandler):
    def get(self):
        b64_data = self.get_argument("b64_data")
        picture_data = base64.b64decode(b64_data)
        with open("image1.jpg", "wb") as f:
            f.write(picture_data)
        print(picture_data)
        result = translation("image.jpg")
        data = {
            "result_word": result,
        }
        requests.get("http://localhost:8000/upload/192.0.0.1", data)


if __name__ == '__main__':
    app = Application(
        [
            (r'/upload', result_handler)
             ],
    )

    http_server = HTTPServer(app)
    http_server.listen(8001)
    IOLoop.current().start()
