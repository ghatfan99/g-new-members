le sch#!/bin/bash
echo " Création du schema arrivants "

# Delete silose if it exists 
psql -h localhost -U silrh silabo -c 'DROP SCHEMA IF EXISTS  n_arrivants CASCADE ;'

# Creation du schema silose (tables , ...)
psql -h localhost -U silrh silabo < createDB.sql

