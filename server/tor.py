#用于Pi

from tornado.web import RequestHandler, Application
from tornado.ioloop import IOLoop
from tornado.httpserver import HTTPServer
import requests
from camera import picture_data
import base64

# 接受图片数据（bit）
class upload_handler(RequestHandler):
    def get(self):
        urls = self.get_argument("urls")
        tmp = base64.b64encode(picture_data())
        data = {
            "b64_data": tmp,
        }
        print(data)
        requests.get(urls, data)


if __name__ == '__main__':
    app = Application(
        [
            (r'/upload', upload_handler),
        ]
    )

    http_server = HTTPServer(app)
    http_server.listen(8000)
    IOLoop.current().start()
