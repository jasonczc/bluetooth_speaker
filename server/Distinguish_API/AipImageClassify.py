from aip import AipImageClassify
import urllib3
""" 你的 APPID AK SK """
APP_ID = '15617758'
API_KEY = 'FI8PyB2DRHec1txYhCWyb7mT'
SECRET_KEY = 'HmhMZdUQI7GBxbHy0iaRSRpoL1GLWL5v'


""" 读取图片 """
def get_file_content(filePath):
    print(filePath)
    with open(filePath, 'rb') as fp:

        return fp.read()

def get_distinguish(path):
    client = AipImageClassify(APP_ID, API_KEY, SECRET_KEY)
    image = get_file_content(path)

    """ 调用通用物体识别 """
    data = client.advancedGeneral(image)
    return data

