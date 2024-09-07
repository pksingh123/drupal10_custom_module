<?php

namespace Drupal\drupal10_custom_module\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "rest_example",
 *   label = @Translation("Rest example"),
 *   uri_paths = {
 *     "canonical" = "/rest/api/get/advertiser"
 *   }
 * )
 */
class RestExample extends ResourceBase {

  /**
   * Responds to GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function get() {

    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
    if (!(\Drupal::currentUser())->hasPermission('access content')) {
       throw new AccessDeniedHttpException();
     }
     
      $nids = \Drupal::entityQuery('advertiser')->condition('field_image',array(3,4,5,6),'IN')->accessCheck(FALSE)->execute();
      if($nids){
        $advertisers =  \Drupal\example_module\Entity\Advertiser::loadMultiple($nids);
        $cnt = 0;
        foreach ($advertisers as $key => $value) {
            $cnt++;
          $data[] = ['id' => $value->id(),'name' => $value->name->value,'raw'=>$value];
        }
        $data['totalCount'] = $cnt;
      }
    
    $response = new ResourceResponse($data);
    // In order to generate fresh result every time (without clearing 
    // the cache), you need to invalidate the cache.
    $response->addCacheableDependency($data);
    return $response;
  }

}
