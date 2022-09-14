<?php namespace October\Test\Classes;

/**
 * StatusEnum
 */
enum StatusEnum:string
{
    case DRAFT = 'draft';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PUBLISHED = 'published';
}
