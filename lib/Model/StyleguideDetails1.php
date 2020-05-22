<?php
/**
 * StyleguideDetails1
 *
 * PHP version 5
 *
 * @category Class
 * @package  Phrase
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Phrase API Reference
 *
 * Phrase is a translation management platform for software projects. You can collaborate on language file translation with your team or order translations through our platform. The API allows you to import locale files, download locale files, tag keys or interact in other ways with the localization data stored in Phrase for your account.  ## API Endpoint  ``` https://api.phrase.com/v2/ ```  The API is only accessible via HTTPS, the base URL is <code>https://api.phrase.com/</code>, and the current version is <code>v2</code> which results in the base URL for all requests: <code>https://api.phrase.com/v2/</code>.  ## Usage  [curl](http://curl.haxx.se/) is used primarily to send requests to Phrase in the examples. On most you'll find a second variant using the [Phrase API v2 client](https://phrase.com/cli/) that might be more convenient to handle. For further information check its [documentation](https://help.phrase.com/help/phrase-in-your-terminal).  ## Use of HTTP Verbs  Phrase API v2 tries to use the appropriate HTTP verb for accessing each endpoint according to REST specification where possible:  <div class=\"table-responsive\">   <table class=\"basic-table\">     <thead>       <tr class=\"basic-table__row basic-table__row--header\">         <th class=\"basic-table__cell basic-table__cell--header\">Verb</th>         <th class=\"basic-table__cell basic-table__cell--header\">Description</th>       </tr>     </thead>     <tbody>       <tr>         <td class=\"basic-table__cell\">GET</td>         <td class=\"basic-table__cell\">Retrieve one or multiple resources</td>       </tr>       <tr>         <td class=\"basic-table__cell\">POST</td>         <td class=\"basic-table__cell\">Create a resource</td>       </tr>       <tr>         <td class=\"basic-table__cell\">PUT</td>         <td class=\"basic-table__cell\">Update a resource</td>       </tr>       <tr>         <td class=\"basic-table__cell\">PATCH</td>         <td class=\"basic-table__cell\">Update a resource (partially)</td>       </tr>       <tr>         <td class=\"basic-table__cell\">DELETE</td>         <td class=\"basic-table__cell\">Delete a resource</td>       </tr>     </tbody>   </table> </div>   ## Identification via User-Agent  You must include the User-Agent header with the name of your application or project. It might be a good idea to include some sort of contact information  as well, so that we can get in touch if necessary (e.g. to warn you about Rate-Limiting or badly formed requests). Examples of excellent User-Agent headers:  ``` User-Agent: Frederiks Mobile App (frederik@phrase.com) User-Agent: ACME Inc Python Client (http://example.com/contact) ```  If you don't send this header, you will receive a response with 400 Bad Request.   ## Lists  When you request a list of resources, the API will typically only return an array of resources including their most important attributes. For a detailed representation of the resource you should request its detailed representation.  Lists are usually [paginated](#pagination).   ## Parameters  Many endpoints support additional parameters, e.g. for pagination. When passing them in a GET request you can send them as HTTP query string parameters:  ``` $ curl -u EMAIL_OR_ACCESS_TOKEN \"https://api.phrase.com/v2/projects?page=2\" ```  When performing a POST, PUT, PATCH or DELETE request, we recommend sending parameters that are not already included in the URL, as JSON body:  ``` $ curl -H 'Content-Type: application/json' -d '{\"name\":\"My new project\"}' -u EMAIL_OR_ACCESS_TOKEN https://api.phrase.com/v2/projects ```  Encoding parameters as JSON means better support for types (boolean, integer) and usually better readability. Don't forget to set the correct Content-Type for your request.  *The Content-Type header is omitted in some of the following examples for better readbility.*   ## Errors   ### Request Errors  If a request contains invalid JSON or is missing a required parameter (besides resource attributes), the status `400 Bad Request` is returned:  ``` {   \"message\": \"JSON could not be parsed\" } ```   ### Validation Errors  When the validation for a resource fails, the status `422 Unprocessable Entity` is returned, along with information on the affected fields:  ``` {   \"message\": \"Validation Failed\",   \"errors\": [     {       \"resource\": \"Project\",       \"field\": \"name\",       \"message\": \"can't be blank\"     }   ] } ```   ## Date Format  Times and dates are returned and expected in [ISO 8601](http://en.wikipedia.org/wiki/ISO_8601) date format:  ``` YYYY-MM-DDTHH:MM:SSZ ```  Instead of 'Z' for UTC time zone you can specify your time zone's locale offset using the following notation:  ``` YYYY-MM-DDTHH:MM:SS¬±hh:mm ```  Example for CET (1 hour behind UTC):  ``` 2015-03-31T13:00+01:00 ```  Please note that in HTTP headers, we will use the appropriate recommended date formats instead of ISO 8601.   ## Authentication  <div class=\"alert alert-info\">For more detailed information on authentication, check out the <a href=\"#authentication\">API v2 Authentication Guide</a>.</div>  There are two different ways to authenticate when performing API requests:  * E-Mail and password * Oauth Access Token   ### E-Mail and password  To get started easily, you can use HTTP Basic authentication with your email and password:  ``` $ curl -u username:password \"https://api.phrase.com/v2/projects\" ```   ### OAuth via Access Tokens  You can create and manage access tokens in your [profile settings](https://app.phrase.com/settings/oauth_access_tokens) in Translation Center or via the [Authorizations API](#authorizations).  Simply pass the access token as the username of your request:  ``` $ curl -u ACCESS_TOKEN: \"https://api.phrase.com/v2/projects\" ```  or send the access token via the `Authorization` header field:  ``` $ curl -H \"Authorization: token ACCESS_TOKEN\" https://api.phrase.com/v2/projects ```  For more detailed information on authentication, check out the <a href=\"#authentication\">API v2 Authentication Guide</a>.  #### Send via parameter  As JSONP (and other) requests cannot send HTTP Basic Auth credentials, a special query parameter `access_token` can be used:  ``` curl \"https://api.phrase.com/v2/projects?access_token=ACCESS_TOKEN\" ```  You should only use this transport method if sending the authentication via header or Basic authentication is not possible.  ### Two-Factor-Authentication  Users with Two-Factor-Authentication enabled have to send a valid token along their request with certain authentication methods (such as Basic authentication). The necessity of a Two-Factor-Authentication token is indicated by the `X-PhraseApp-OTP: required; :MFA-type` header in the response. The `:MFA-type`field indicates the source of the token, e.g. `app` (refers to your Authenticator application):  ``` X-PhraseApp-OTP: required; app ```  To provide a Two-Factor-Authentication token you can simply send it in the header of the request:  ``` curl -H \"X-PhraseApp-OTP: MFA-TOKEN\" -u EMAIL https://api.phrase.com/v2/projects ```  Since Two-Factor-Authentication tokens usually expire quickly, we recommend using an alternative authentication method such as OAuth access tokens.  ### Multiple Accounts  Some endpoints require the account ID to be specified if the authenticated user is a member of multiple accounts. You can find the eight-digit account ID inside <a href=\"https://app.phrase.com/\" target=\"_blank\">Translation Center</a> by switching to the desired account and then visiting the account details page. If required, you can specify the account just like a normal parameter within the request.  ## Pagination  Endpoints that return a list or resources will usually return paginated results and include 25 items by default. To access further pages, use the `page` parameter:  ``` $ curl -u EMAIL_OR_ACCESS_TOKEN \"https://api.phrase.com/v2/projects?page=2\" ```  Some endpoints also allow a custom page size by using the `per_page` parameter:  ``` $ curl -u EMAIL_OR_ACCESS_TOKEN \"https://api.phrase.com/v2/projects?page=2&per_page=50\" ```  Unless specified otherwise in the description of the respective endpoint, `per_page` allows you to specify a page size up to 100 items.   ## Link-Headers  We provide you with pagination URLs in the [Link Header field](http://tools.ietf.org/html/rfc5988). Make use of this information to avoid building pagination URLs yourself.  ``` Link: <https://api.phrase.com/v2/projects?page=1>; rel=\"first\", <https://api.phrase.com/v2/projects?page=3>; rel=\"prev\", <https://api.phrase.com/v2/projects?page=5>; rel=\"next\", <https://api.phrase.com/v2/projects?page=9>; rel=\"last\" ```  Possible `rel` values are:  <div class=\"table-responsive\">   <table class=\"basic-table\">     <thead>       <tr class=\"basic-table__row basic-table__row--header\">         <th class=\"basic-table__cell basic-table__cell--header\">Value</th>         <th class=\"basic-table__cell basic-table__cell--header\">Description</th>       </tr>     </thead>     <tbody>       <tr>         <td class=\"basic-table__cell\">next</td>         <td class=\"basic-table__cell\">URL of the next page of results</td>       </tr>       <tr>         <td class=\"basic-table__cell\">last</td>         <td class=\"basic-table__cell\">URL of the last page of results</td>       </tr>       <tr>         <td class=\"basic-table__cell\">first</td>         <td class=\"basic-table__cell\">URL of the first page of results</td>       </tr>       <tr>         <td class=\"basic-table__cell\">prev</td>         <td class=\"basic-table__cell\">URL of the previous page of results</td>       </tr>     </tbody>   </table> </div>  ## Rate Limiting  All API endpoints are subject to rate limiting to ensure good performance for all customers. The rate limit is calculated per user:  * 1000 requests per 5 minutes * 4 concurrent (parallel) requests  For your convenience we send information on the current rate limit within the response headers:  <div class=\"table-responsive\">   <table class=\"basic-table\">     <thead>       <tr class=\"basic-table__row basic-table__row--header\">         <th class=\"basic-table__cell basic-table__cell--header\">Header</th>         <th class=\"basic-table__cell basic-table__cell--header\">Description</th>       </tr>     </thead>     <tbody>       <tr>         <td class=\"basic-table__cell\" style=\"white-space: nowrap;\"><code>X-Rate-Limit-Limit</code></td>         <td class=\"basic-table__cell\">Number of max requests allowed in the current time period</td>       </tr>       <tr>         <td class=\"basic-table__cell\" style=\"white-space: nowrap;\"><code>X-Rate-Limit-Remaining</code></td>         <td class=\"basic-table__cell\">Number of remaining requests in the current time period</td>       </tr>       <tr>         <td class=\"basic-table__cell\" style=\"white-space: nowrap;\"><code>X-Rate-Limit-Reset</code></td>         <td class=\"basic-table__cell\">Timestamp of end of current time period as UNIX timestamp</td>       </tr>     </tbody>   </table> </div>  If you should run into the rate limit, you will receive the HTTP status code `429: Too many requests`.  If you should need higher rate limits, [contact us](https://phrase.com/contact).   ## Conditional GET requests / HTTP Caching  <div class=\"alert alert-info\"><p><strong>Note:</strong> Conditional GET requests are currently only supported for <a href=\"#locales_download\">locales#download</a> and <a href=\"#translations_index\">translations#index</a></p></div>  We will return an ETag or Last-Modified header with most GET requests. When you request a resource we recommend to store this value and submit them on subsequent requests as `If-Modified-Since` and `If-None-Match` headers. If the resource has not changed in the meantime, we will return the status `304 Not Modified` instead of rendering and returning the resource again. In most cases this is less time-consuming and makes your application/integration faster.  Please note that all conditional requests that return a response with status 304 don't count against your rate limits.  ``` $ curl -i -u EMAIL_OR_ACCESS_TOKEN \"https://api.phrase.com/v2/projects/1234abcd1234abcdefefabcd1234efab/locales/en/download\" HTTP/1.1 200 OK ETag: \"abcd1234abcdefefabcd1234efab1234\" Last-Modified: Wed, 28 Jan 2015 15:31:30 UTC Status: 200 OK  $ curl -i -u EMAIL_OR_ACCESS_TOKEN \"https://api.phrase.com/v2/projects/1234abcd1234abcdefefabcd1234efab/locales/en/download\" -H 'If-None-Match: \"abcd1234abcdefefabcd1234efab1234\"' HTTP/1.1 304 Not Modified ETag: \"abcd1234abcdefefabcd1234efab1234\" Last-Modified: Wed, 28 Jan 2015 15:31:30 UTC Status: 304 Not Modified  $ curl -i -u EMAIL_OR_ACCESS_TOKEN \"https://api.phrase.com/v2/projects/1234abcd1234abcdefefabcd1234efab/locales/en/download\" -H \"If-Modified-Since: Wed, 28 Jan 2015 15:31:30 UTC\" HTTP/1.1 304 Not Modified Last-Modified: Wed, 28 Jan 2015 15:31:30 UTC Status: 304 Not Modified ```   ## JSONP  The Phrase API supports [JSONP](http://en.wikipedia.org/wiki/JSONP) for all GET requests in order to deal with cross-domain request issues. Just send a `?callback` parameter along with the request to specify the Javascript function name to be called with the response content:  ``` $ curl \"https://api.phrase.com/v2/projects?callback=myFunction\" ```  The response will include the normal output for that endpoint, along with a `meta` section including header data:  ``` myFunction({   {     \"meta\": {       \"status\": 200,       ...     },     \"data\": [       {         \"id\": \"1234abcd1234abc1234abcd1234abc\"         ...       }     ]   } }); ```  To authenticate a JSONP request, you can send a valid [access token](#authentication) as the `?access_token` parameter along the request:  ``` $ curl \"https://api.phrase.com/v2/projects?callback=myFunction&access_token=ACCESS-TOKEN\" ```
 *
 * The version of the OpenAPI document: 2.0.0
 * Contact: support@phrase.com
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 4.3.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Phrase\Model;

use \ArrayAccess;
use \Phrase\ObjectSerializer;

/**
 * StyleguideDetails1 Class Doc Comment
 *
 * @category Class
 * @package  Phrase
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class StyleguideDetails1 implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'styleguide_details_1';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'public_url' => 'string',
        'audience' => 'string',
        'target_audience' => 'string',
        'grammatical_person' => 'string',
        'vocabulary_type' => 'string',
        'business' => 'string',
        'company_branding' => 'string',
        'formatting' => 'string',
        'glossary_terms' => 'string',
        'grammar_consistency' => 'string',
        'literal_translation' => 'string',
        'overall_tone' => 'string',
        'samples' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPIFormats = [
        'public_url' => null,
        'audience' => null,
        'target_audience' => null,
        'grammatical_person' => null,
        'vocabulary_type' => null,
        'business' => null,
        'company_branding' => null,
        'formatting' => null,
        'glossary_terms' => null,
        'grammar_consistency' => null,
        'literal_translation' => null,
        'overall_tone' => null,
        'samples' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'public_url' => 'public_url',
        'audience' => 'audience',
        'target_audience' => 'target_audience',
        'grammatical_person' => 'grammatical_person',
        'vocabulary_type' => 'vocabulary_type',
        'business' => 'business',
        'company_branding' => 'company_branding',
        'formatting' => 'formatting',
        'glossary_terms' => 'glossary_terms',
        'grammar_consistency' => 'grammar_consistency',
        'literal_translation' => 'literal_translation',
        'overall_tone' => 'overall_tone',
        'samples' => 'samples'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'public_url' => 'setPublicUrl',
        'audience' => 'setAudience',
        'target_audience' => 'setTargetAudience',
        'grammatical_person' => 'setGrammaticalPerson',
        'vocabulary_type' => 'setVocabularyType',
        'business' => 'setBusiness',
        'company_branding' => 'setCompanyBranding',
        'formatting' => 'setFormatting',
        'glossary_terms' => 'setGlossaryTerms',
        'grammar_consistency' => 'setGrammarConsistency',
        'literal_translation' => 'setLiteralTranslation',
        'overall_tone' => 'setOverallTone',
        'samples' => 'setSamples'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'public_url' => 'getPublicUrl',
        'audience' => 'getAudience',
        'target_audience' => 'getTargetAudience',
        'grammatical_person' => 'getGrammaticalPerson',
        'vocabulary_type' => 'getVocabularyType',
        'business' => 'getBusiness',
        'company_branding' => 'getCompanyBranding',
        'formatting' => 'getFormatting',
        'glossary_terms' => 'getGlossaryTerms',
        'grammar_consistency' => 'getGrammarConsistency',
        'literal_translation' => 'getLiteralTranslation',
        'overall_tone' => 'getOverallTone',
        'samples' => 'getSamples'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['public_url'] = isset($data['public_url']) ? $data['public_url'] : null;
        $this->container['audience'] = isset($data['audience']) ? $data['audience'] : null;
        $this->container['target_audience'] = isset($data['target_audience']) ? $data['target_audience'] : null;
        $this->container['grammatical_person'] = isset($data['grammatical_person']) ? $data['grammatical_person'] : null;
        $this->container['vocabulary_type'] = isset($data['vocabulary_type']) ? $data['vocabulary_type'] : null;
        $this->container['business'] = isset($data['business']) ? $data['business'] : null;
        $this->container['company_branding'] = isset($data['company_branding']) ? $data['company_branding'] : null;
        $this->container['formatting'] = isset($data['formatting']) ? $data['formatting'] : null;
        $this->container['glossary_terms'] = isset($data['glossary_terms']) ? $data['glossary_terms'] : null;
        $this->container['grammar_consistency'] = isset($data['grammar_consistency']) ? $data['grammar_consistency'] : null;
        $this->container['literal_translation'] = isset($data['literal_translation']) ? $data['literal_translation'] : null;
        $this->container['overall_tone'] = isset($data['overall_tone']) ? $data['overall_tone'] : null;
        $this->container['samples'] = isset($data['samples']) ? $data['samples'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets public_url
     *
     * @return string|null
     */
    public function getPublicUrl()
    {
        return $this->container['public_url'];
    }

    /**
     * Sets public_url
     *
     * @param string|null $public_url public_url
     *
     * @return $this
     */
    public function setPublicUrl($public_url)
    {
        $this->container['public_url'] = $public_url;

        return $this;
    }

    /**
     * Gets audience
     *
     * @return string|null
     */
    public function getAudience()
    {
        return $this->container['audience'];
    }

    /**
     * Sets audience
     *
     * @param string|null $audience audience
     *
     * @return $this
     */
    public function setAudience($audience)
    {
        $this->container['audience'] = $audience;

        return $this;
    }

    /**
     * Gets target_audience
     *
     * @return string|null
     */
    public function getTargetAudience()
    {
        return $this->container['target_audience'];
    }

    /**
     * Sets target_audience
     *
     * @param string|null $target_audience target_audience
     *
     * @return $this
     */
    public function setTargetAudience($target_audience)
    {
        $this->container['target_audience'] = $target_audience;

        return $this;
    }

    /**
     * Gets grammatical_person
     *
     * @return string|null
     */
    public function getGrammaticalPerson()
    {
        return $this->container['grammatical_person'];
    }

    /**
     * Sets grammatical_person
     *
     * @param string|null $grammatical_person grammatical_person
     *
     * @return $this
     */
    public function setGrammaticalPerson($grammatical_person)
    {
        $this->container['grammatical_person'] = $grammatical_person;

        return $this;
    }

    /**
     * Gets vocabulary_type
     *
     * @return string|null
     */
    public function getVocabularyType()
    {
        return $this->container['vocabulary_type'];
    }

    /**
     * Sets vocabulary_type
     *
     * @param string|null $vocabulary_type vocabulary_type
     *
     * @return $this
     */
    public function setVocabularyType($vocabulary_type)
    {
        $this->container['vocabulary_type'] = $vocabulary_type;

        return $this;
    }

    /**
     * Gets business
     *
     * @return string|null
     */
    public function getBusiness()
    {
        return $this->container['business'];
    }

    /**
     * Sets business
     *
     * @param string|null $business business
     *
     * @return $this
     */
    public function setBusiness($business)
    {
        $this->container['business'] = $business;

        return $this;
    }

    /**
     * Gets company_branding
     *
     * @return string|null
     */
    public function getCompanyBranding()
    {
        return $this->container['company_branding'];
    }

    /**
     * Sets company_branding
     *
     * @param string|null $company_branding company_branding
     *
     * @return $this
     */
    public function setCompanyBranding($company_branding)
    {
        $this->container['company_branding'] = $company_branding;

        return $this;
    }

    /**
     * Gets formatting
     *
     * @return string|null
     */
    public function getFormatting()
    {
        return $this->container['formatting'];
    }

    /**
     * Sets formatting
     *
     * @param string|null $formatting formatting
     *
     * @return $this
     */
    public function setFormatting($formatting)
    {
        $this->container['formatting'] = $formatting;

        return $this;
    }

    /**
     * Gets glossary_terms
     *
     * @return string|null
     */
    public function getGlossaryTerms()
    {
        return $this->container['glossary_terms'];
    }

    /**
     * Sets glossary_terms
     *
     * @param string|null $glossary_terms glossary_terms
     *
     * @return $this
     */
    public function setGlossaryTerms($glossary_terms)
    {
        $this->container['glossary_terms'] = $glossary_terms;

        return $this;
    }

    /**
     * Gets grammar_consistency
     *
     * @return string|null
     */
    public function getGrammarConsistency()
    {
        return $this->container['grammar_consistency'];
    }

    /**
     * Sets grammar_consistency
     *
     * @param string|null $grammar_consistency grammar_consistency
     *
     * @return $this
     */
    public function setGrammarConsistency($grammar_consistency)
    {
        $this->container['grammar_consistency'] = $grammar_consistency;

        return $this;
    }

    /**
     * Gets literal_translation
     *
     * @return string|null
     */
    public function getLiteralTranslation()
    {
        return $this->container['literal_translation'];
    }

    /**
     * Sets literal_translation
     *
     * @param string|null $literal_translation literal_translation
     *
     * @return $this
     */
    public function setLiteralTranslation($literal_translation)
    {
        $this->container['literal_translation'] = $literal_translation;

        return $this;
    }

    /**
     * Gets overall_tone
     *
     * @return string|null
     */
    public function getOverallTone()
    {
        return $this->container['overall_tone'];
    }

    /**
     * Sets overall_tone
     *
     * @param string|null $overall_tone overall_tone
     *
     * @return $this
     */
    public function setOverallTone($overall_tone)
    {
        $this->container['overall_tone'] = $overall_tone;

        return $this;
    }

    /**
     * Gets samples
     *
     * @return string|null
     */
    public function getSamples()
    {
        return $this->container['samples'];
    }

    /**
     * Sets samples
     *
     * @param string|null $samples samples
     *
     * @return $this
     */
    public function setSamples($samples)
    {
        $this->container['samples'] = $samples;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


