# Imports the Google Cloud Translation library
from google.cloud import translate
import argparse
import logging, coloredlogs

from database import Database

logger = logging.getLogger("main")
log_fmt_str = "[%(asctime)s] %(levelname)s | Main | %(message)s"
log_fmt = logging.Formatter(log_fmt_str)
fileHandler = logging.FileHandler("{0}/{1}.log".format("log", "main"), encoding="utf-8")
fileHandler.setFormatter(log_fmt)

consoleHandler = logging.StreamHandler()
consoleHandler.setFormatter(log_fmt)

logger.addHandler(fileHandler)
logger.addHandler(consoleHandler)

logger.setLevel(logging.INFO)
coloredlogs.install(logging.INFO, logger=logger, fmt=log_fmt_str)

parser = argparse.ArgumentParser(description="Demo for google cloud translate")
parser.add_argument("-t", "--text", type=str, default="Good Morning!", help="English text to translate to german")
args = parser.parse_args()

data = Database()

# Initialize Translation client

text=args.text
project_id="esoteric-life-339900"

client = translate.TranslationServiceClient()

location = "global"

parent = f"projects/{project_id}/locations/{location}"

# Translate text from English to French
# Detail on supported types can be found here:
# https://cloud.google.com/translate/docs/supported-formats
response = client.translate_text(
    request={
        "parent": parent,
        "contents": [text],
        "mime_type": "text/plain",  # mime types: text/plain, text/html
        "source_language_code": "en-US",
        "target_language_code": "de-DE",
    }
)

# Display the translation for each input text provided
for translation in response.translations:
    data.put_translation(args.text, translation.translated_text)
    logger.info(f"Translated text: {translation.translated_text}")
