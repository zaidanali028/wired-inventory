import sys
from PIL import Image
from rembg import remove
import os
import path
input_img_name=sys.argv[1]
# print(input_img_name)
input = Image.open(input_img_name)

output = remove(input)
# # makes an image transparent
# print(sys.argv[2]+'lol.jpg')
output_img_name='wei.png'
result_img_name='s3asa'
output.save(output_img_name)
# # save transparent image

output_img=Image.open(output_img_name).convert("RGBA")
# # convert transparent image to rgb
new_image = Image.new("RGBA", output_img.size, (22,55,101))
new_image.paste(output_img, mask=output_img)
# override transparent bg with a bg color

new_image.convert("RGB").save(result_img_name)

# remove transparent image
os.remove(output_img_name)
print ()
