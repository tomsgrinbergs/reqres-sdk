<?php

namespace Tomsgrinbergs\ReqresSdk\DTOs;

/** @template T of BaseDTO */
abstract class PaginationDTO extends BaseDTO
{
    public function __construct(
        /** @var array<T> */
        public array $data,
        public int $page,
        public int $per_page,
        public int $total,
        public int $total_pages,
    ) {
    }
}
