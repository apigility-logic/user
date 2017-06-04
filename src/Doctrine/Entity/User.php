<?php

namespace ApigilityLogic\User\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

use ZF\OAuth2\Doctrine\Entity\UserInterface;
use Zend\Stdlib\ArraySerializableInterface;
use ApigilityLogic\Address\Doctrine\Entity\Address;

/**
 * Class User
 * @package ApigilityLogic\User\Doctrine\Entity
 * @Entity @Table(name="al_user_user")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 */
class User implements UserInterface, ArraySerializableInterface
{
    const SEX_MALE = 1;    // 男性
    const SEX_FEMALE = 2;  // 女性

    const EDUCATION_NONE = 1;        // 没有受过教育
    const EDUCATION_ELEMENTARY = 2;  // 小学
    const EDUCATION_JUNIOR_HIGH = 3; // 初中
    const EDUCATION_SENIOR_HIGH = 4; // 高中
    const EDUCATION_COLLEGE = 5;   // 大专
    const EDUCATION_BACHELOR = 6;  // 本科
    const EDUCATION_MASTER = 7; // 硕士
    const EDUCATION_DOCTOR = 8; // 博士

    const EMOTION_SINGLE = 1;  // 单身
    const EMOTION_IN_LOVE = 2;  // 热恋
    const EMOTION_MARRIED = 3;  // 已婚

    const ZODIAC_CAPRICORN = 1; // 魔羯座
    const ZODIAC_AQUARIUS = 2; // 水瓶座
    const ZODIAC_PISCES = 3; // 双鱼座
    const ZODIAC_ARIES = 4; // 牡羊座
    const ZODIAC_TAURUS = 5; // 金牛座
    const ZODIAC_GEMINI = 6; // 双子座
    const ZODIAC_CANCER = 7; // 巨蟹座
    const ZODIAC_LEO = 8; // 狮子座
    const ZODIAC_VIRGO = 9; // 处女座
    const ZODIAC_LIBRA = 10; // 天秤座
    const ZODIAC_SCORPIO = 11; // 天蝎座
    const ZODIAC_SAGITTARIUS = 12; // 射手座

    const CHINESE_ZODIAC_RAT = 1; // 鼠
    const CHINESE_ZODIAC_OX = 2; // 牛
    const CHINESE_ZODIAC_TIGER = 3; // 虎
    const CHINESE_ZODIAC_HARE = 4; // 兔
    const CHINESE_ZODIAC_DRAGON = 5; // 龙
    const CHINESE_ZODIAC_SNAKE = 6; // 蛇
    const CHINESE_ZODIAC_HORSE = 7; // 马
    const CHINESE_ZODIAC_SHEEP = 8; // 羊
    const CHINESE_ZODIAC_MONKEY = 9; // 猴
    const CHINESE_ZODIAC_COCK = 10; // 鸡
    const CHINESE_ZODIAC_DOG = 11; // 狗
    const CHINESE_ZODIAC_BOAR = 12; // 猪

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 昵称
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $nickname;

    /**
     * 头像地址
     *
     * @Column(type="string", length=255, nullable=true)
     */
    protected $avatar;

    /**
     * 性别
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $sex;

    /**
     * 年龄
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $age;

    /**
     * 生日
     *
     * @Column(type="datetime", nullable=true)
     */
    protected $birthday;

    /**
     * 身高
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $stature;

    /**
     * 体重
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $weight;

    /**
     * 学历
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $education;

    /**
     * 感情状态
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $emotion;

    /**
     * 星座
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $zodiac;

    /**
     * 生肖
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $chinese_zodiac;

    /**
     * 关联的所有地址
     * @OneToMany(targetEntity="UserAddress", mappedBy="user")
     */
    protected $addresses;

    /**
     * 居住地址
     *
     * @OneToOne(targetEntity="ResidenceAddress")
     * @JoinColumn(name="residence_address_id", referencedColumnName="id")
     */
    protected $residence_address;

    /**
     * 户口地址
     *
     * @OneToOne(targetEntity="CensusRegisterAddress")
     * @JoinColumn(name="census_register_address_id", referencedColumnName="id")
     */
    protected $census_register_address;

    /**
     * 个人实名认证
     *
     * @OneToOne(targetEntity="PersonalCertification", mappedBy="user")
     */
    protected $personalCertification;

    /**
     * 职业认证
     *
     * @OneToMany(targetEntity="ProfessionalCertification", mappedBy="user")
     */
    protected $professionalCertifications;

    /**
     * 职业
     *
     * @ManyToOne(targetEntity="Occupation", inversedBy="users")
     * @JoinColumn(name="occupation_id", referencedColumnName="id")
     */
    protected $occupation;

    /**
     * 收入等级
     *
     * @ManyToOne(targetEntity="IncomeLevel", inversedBy="users")
     * @JoinColumn(name="income_level_id", referencedColumnName="id")
     */
    protected $income_level;

    protected $client;
    protected $accessToken;
    protected $authorizationCode;
    protected $refreshToken;

    // OpenID fields
    protected $username;
    protected $password;
    protected $profile;
    protected $email;
    protected $country;
    protected $phone_number;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->professionalCertifications = new ArrayCollection();
    }


    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setStature($stature)
    {
        $this->stature = $stature;
        return $this;
    }

    public function getStature()
    {
        return $this->stature;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setEducation($education)
    {
        $this->education = $education;
        return $this;
    }

    public function getEducation()
    {
        return $this->education;
    }

    public function setEmotion($emotion)
    {
        $this->emotion = $emotion;
        return $this;
    }

    public function getEmotion()
    {
        return $this->emotion;
    }

    public function setZodiac($zodiac)
    {
        $this->zodiac = $zodiac;
        return $this;
    }

    public function getZodiac()
    {
        return $this->zodiac;
    }

    public function setChineseZodiac($chinese_zodiac)
    {
        $this->chinese_zodiac = $chinese_zodiac;
        return $this;
    }

    public function getChineseZodiac()
    {
        return $this->chinese_zodiac;
    }

    public function setPersonalCertification($personalCertification)
    {
        $this->personalCertification = $personalCertification;
        return $this;
    }

    public function getPersonalCertification()
    {
        return $this->personalCertification;
    }

    public function setProfessionalCertifications($professionalCertifications)
    {
        $this->professionalCertifications = $professionalCertifications;
        return $this;
    }

    public function getProfessionalCertifications()
    {
        return $this->professionalCertifications;
    }

    public function addProfessionalCertification($professionalCertification)
    {
        $this->professionalCertifications[] = $professionalCertification;
    }

    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
        return $this;
    }

    /**
     * @return Occupation
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    public function setIncomeLevel($income_level)
    {
        $this->income_level = $income_level;
        return $this;
    }

    /**
     * @return IncomeLevel
     */
    public function getIncomeLevel()
    {
        return $this->income_level;
    }

    public function setResidenceAddress($residence_address)
    {
        $this->residence_address = $residence_address;
        return $this;
    }

    /**
     * @return Address
     */
    public function getResidenceAddress()
    {
        return $this->residence_address;
    }

    public function setCensusRegisterAddress($census_register_address)
    {
        $this->census_register_address = $census_register_address;
        return $this;
    }

    /**
     * @return Address
     */
    public function getCensusRegisterAddress()
    {
        return $this->census_register_address;
    }

    public function exchangeArray(array $data)
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'username':
                    $this->setUsername($value);
                    break;
                case 'password':
                    $this->setPassword($value);
                    break;
                case 'profile':
                    $this->setProfile($value);
                    break;
                case 'email':
                    $this->setEmail($value);
                    break;
                case 'country':
                    $this->setAddress($value);
                    break;
                case 'phone_number':
                case 'phoneNumber':
                    $this->setPhone($value);
                    break;
                default:
                    break;
            }
        }

        return $this;
    }

    public function getArrayCopy()
    {
        return array(
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'profile' => $this->getProfile(),
            'email' => $this->getEmail(),
            'country' => $this->getCountry(),
            'phone_number' => $this->getPhoneNumber(), // underscore formatting for openid
            'phoneNumber' => $this->getPhoneNumber(),
        );
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function setPhoneNumber($value)
    {
        $this->phone_number = $value;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($value)
    {
        $this->country = $value;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;

        return $this;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function setProfile($value)
    {
        $this->profile = $value;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($value)
    {
        $this->username = $value;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($value)
    {
        $this->password = $value;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}
