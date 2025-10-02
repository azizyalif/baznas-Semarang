<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DataFeed extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'datafeeds';

    /**
     * Retrieves specific data types from the db
     *
     * @param int $dataType
     * @param string $field
     * @return mixed
     */
    public function getDataFeed($limit = null)
    {
        $query = self::select('proposal.kecamatan', DB::raw('COUNT(proposal.id) as jumlah'))
            ->where('proposal.dibantu', '2')
            ->whereNotNull('proposal.kecamatan')
            ->groupBy('proposal.kecamatan')
            ->orderBy('jumlah', 'asc');
            
        if (null !== $limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }

    /**
     * Counts a set of data based on the datatype
     *
     * @param int $dataType
     * @param int|null $limit
     * @return mixed
     */
    public function sumDataSet(int $dataType, ?int $dataset = null)
    {
        $query = $this->where('data_type', $dataType)
            ->where(function($q) use($dataset) {
                if (null !== $dataset) {
                    $q->where('dataset_name', $dataset);
                }
            })
            ->sum('data');

        return $query;
    }    
}
