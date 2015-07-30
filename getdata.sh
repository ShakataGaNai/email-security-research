#!/bin/bash
wget https://ak.quantcast.com/quantcast-top-million.zip
unzip -o quantcast-top-million.zip
rm quantcast-top-million.zip
head -n 56 Quantcast-Top-Million.txt | tail -n 50 > top50.txt
