<?php namespace October\Test\Classes;

/**
 * StatusEnum defines the comment status values, testing an attribute cast to a backed enum.
 */
enum StatusEnum: string
{
    case Draft = 'draft';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Published = 'published';
}
