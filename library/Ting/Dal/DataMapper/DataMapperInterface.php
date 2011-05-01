<?php

namespace Ting\Dal\DataMapper;

interface DataMapperInterface
{
    public function save();
    public function findById($id);
}

