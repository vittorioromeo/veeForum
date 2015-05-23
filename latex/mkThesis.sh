#!/bin/bash

latexpp ./thesis.lpp > ./thesis.tex
pdflatex -shell-escape ./thesis.tex && pdflatex -shell-escape ./thesis.tex && chromium ./thesis.pdf