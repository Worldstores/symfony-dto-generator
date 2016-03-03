<?php

namespace WsSys\DtoGeneratorBundle\Generator;

/**
 * Generates Controller on the basis of Dto
 */
class ApiControllerGenerator
{
    /**
     * Bundle where to generate the controller
     * 
     * @var string 
     */
    protected $bundle;
    
    /**
     * Sets the bundle
     * 
     * @param string $bundle
     * @return ApiControllerGenerator
     */
    public function setBundle($bundle)
    {
        $this->bundle = $bundle;
        
        return $this;
    }
    
    /**
     * Returns the bundle
     * 
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }
    
    /**
     * Generates the Controller and some behat test features
     * 
     * @param string $dtoClassName
     * @param boolean $forceOverwrite
     */
    public function generate($dtoClassName, $dataFormat = 'json', $forceOverwrite = true)
    {
        $dir = $this->bundle->getPath();
        $target = sprintf(
            '%s/Controller/%sController.php',
            $dir,
            $dtoClassName
        );

        if (!$forceOverwrite && file_exists($target)) {
            throw new \RuntimeException('Unable to generate the controller as it already exists.');
        }

        $this->renderFile('controller.php.twig', $target, array(
            'dto_class'         => $dtoClassName,
            'date_since'        => new \DateTime(),
            'bundle_namespace'  => $this->bundle->getNamespace(),
            'bundle_name'       => $this->bundle->getName()
        ));
        $this->generateFeatures($dtoClassName, $dataFormat);
    }
    
    /**
     * Generate Basic feature file
     * 
     * @param string $dtoClassname
     */
    public function generateFeatures($dtoClassName, $dataFormat = 'json')
    {
        $dir    = $this->bundle->getPath() . '/../../features';
        $target = sprintf('%s/%s.feature', $dir, strtolower($dtoClassName));

        $this->renderFile('feature.feature.twig', $target, array(
            'dto_class'         => $dtoClassName,
            'bundle_namespace'  => $this->bundle->getNamespace(),
            'bundle_name'       => $this->bundle->getName(),
            'format'            => $dataFormat,
            'url'               => '/' . strtolower($dtoClassName)
        ));
    }
}