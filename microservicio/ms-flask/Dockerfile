FROM python:3

COPY requirements.txt /usr/src/app/
WORKDIR /usr/src/app
EXPOSE 5000
RUN pip install -r requirements.txt

ENTRYPOINT ["python3"]
CMD ["app.py"]