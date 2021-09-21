<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\UriEntry;
use App\Exception\AppException;
use App\Repository\UriEntryRepository;
use App\Traits\EntityManagerAwareTrait;
use Symfony\Component\HttpFoundation\Response;

class UriEntryManager
{
    use EntityManagerAwareTrait;

    /**
     * @var UriEntryRepository
     */
    private UriEntryRepository $uriEntryRepository;

    /**
     * UriEntryManager constructor.
     * @param UriEntryRepository $uriEntryRepository
     */
    public function __construct(UriEntryRepository $uriEntryRepository)
    {
        $this->uriEntryRepository = $uriEntryRepository;
    }

    /**
     * @param string $longUri
     * @return string
     * @throws AppException
     */
    public function create(string $longUri): string
    {
        if (!filter_var($longUri, FILTER_VALIDATE_URL))
        {
            throw new AppException("This is not a URL", Response::HTTP_BAD_REQUEST);
        }

        $parsedUrl = parse_url($longUri);
        $newToken = $this->randUniqId(rand(1000000000, 9999999999));
        $shortUri = $parsedUrl['scheme'] . "://" . $newToken;

        $checkUri = $this->uriEntryRepository->findOneBy(['longUri' => $longUri]);

        if ($checkUri instanceof UriEntry) {
            $checkUri->setExpireTime();
        } else {
            $uriEntry = new UriEntry($longUri, $shortUri);
            $this->entityManager->persist($uriEntry);
        }
        $this->entityManager->flush();

        return $shortUri;
    }

    /**
     * @param string $shortUri
     * @return string|null
     */
    public function findLongUriByShortUri(string $shortUri): ?string
    {
        $result = $this->uriEntryRepository->findOneBy(['shortUri' => $shortUri]);
        return $result->getLongUri();
    }

    /**
     * @param int $in
     * @param bool $to_num
     * @param bool $pad_up
     * @param string|null $passKey
     * @return false|string
     */
    function randUniqId(int $in, bool $to_num = false, bool $pad_up = false, ?string $passKey = null)
    {
        $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($passKey !== null) {

            for ($n = 0; $n<strlen($index); $n++) {
                $i[] = substr( $index,$n ,1);
            }

            $passhash = hash('sha256',$passKey);
            $passhash = (strlen($passhash) < strlen($index))
                ? hash('sha512',$passKey)
                : $passhash;

            for ($n=0; $n < strlen($index); $n++) {
                $p[] =  substr($passhash, $n ,1);
            }

            array_multisort($p,  SORT_DESC, $i);
            $index = implode($i);
        }

        $base  = strlen($index);

        if ($to_num) {
            $in  = strrev($in);
            $out = 0;
            $len = strlen($in) - 1;
            for ($t = 0; $t <= $len; $t++) {
                $bcpow = bcpow($base, $len - $t);
                $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
            }

            if (is_numeric($pad_up)) {
                $pad_up--;
                if ($pad_up > 0) {
                    $out -= pow($base, $pad_up);
                }
            }
            $out = sprintf('%F', $out);
            $out = substr($out, 0, strpos($out, '.'));
        } else {
            if (is_numeric($pad_up)) {
                $pad_up--;
                if ($pad_up > 0) {
                    $in += pow($base, $pad_up);
                }
            }

            $out = "";
            for ($t = floor(log($in, $base)); $t >= 0; $t--) {
                $bcp = bcpow(strval($base), strval($t));
                $a   = floor($in / $bcp) % $base;
                $out = $out . substr($index, $a, 1);
                $in  = $in - ($a * $bcp);
            }
            $out = strrev($out); // reverse
        }

        return $out;
    }
}
