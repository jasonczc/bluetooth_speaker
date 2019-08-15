import pygame.camera


def picture_data():
    pygame.init()
    pygame.camera.init()
    camera = pygame.camera.Camera("/dev/video0", (244, 244))
    camera.start()
    image = camera.get_image()
    print(image)
    pygame.image.save(image, "image.jpg")
    camera.stop()
    with open("image.jpg", "rb") as image:
        return image.read()
