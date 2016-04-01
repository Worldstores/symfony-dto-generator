<?php

namespace WsSys\DtoGeneratorBundle\Generator;

/**
 * Generates Controller on the basis of Dto
 */
class ApiControllerGenerator extends AbstractGenerator
{
    /**
     * Bundle where to generate the controller
     * 
     * @var string 
     */
    protected $bundle;
    
    /**
     * @var string 
     */
    protected $dtoClassName;
    
    /**
     * @var string 
     */
    protected $dataFormat = 'json';
    
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
     * sets Dto Class name
     * 
     * @param string $dtoClassName
     * @return ApiControllerGenerator
     */
    public function setDtoClassName($dtoClassName)
    {
        $this->dtoClassName = $dtoClassName;
        
        return $this;
    }
    
    /**
     * Returns Dto class name
     * 
     * @return string
     */
    public function getDtoClassName()
    {
        return $this->dtoClassName;
    }
    
    /**
     * Sets data format
     * 
     * @param string $dataFormat
     * @return ApiControllerGenerator
     */
    public function setDataFormat($dataFormat)
    {
        $this->dataFormat = $dataFormat;
        
        return $this;
    }
    
    /**
     * Gets Data format
     * 
     * @return string
     */
    public function getDataFormat()
    {
        return $this->dataFormat;
    }

    /**
     * Generates the Controller and some behat test features
     * 
     * @param boolean $forceOverwrite
     */
    public function generate($forceOverwrite = true)
    {
        $dir = $this->bundle->getPath();
        $target = sprintf(
            '%s/Controller/%sController.php',
            $dir,
            $this->dtoClassName
        );

        if (!$forceOverwrite && file_exists($target)) {
            throw new \RuntimeException('Unable to generate the controller as it already exists.');
        }

        $dateSince = new \DateTime();
        
        $this->renderFile('controller.php.twig', $target, array(
            'dto_class'         => $this->dtoClassName,
            'date_since'        => $dateSince->format('Y-m-d'),
            'bundle_namespace'  => $this->bundle->getNamespace(),
            'bundle_name'       => $this->bundle->getName()
        ));
        $this->generateFeatures($this->dtoClassName, $this->dataFormat);
    }
    
    /**
     * Generate Basic feature file
     * 
     * @param string $dtoClassname
     */
    public function generateFeatures($dtoClassName, $dataFormat = 'json')
    {
        $dir    = $this->bundle->getPath() . '/../../../features';
        $target = sprintf('%s/%s.feature', $dir, strtolower($dtoClassName));

        $this->renderFile('feature.php.twig', $target, array(
            'dto_class'         => $dtoClassName,
            'bundle_namespace'  => $this->bundle->getNamespace(),
            'bundle_name'       => $this->bundle->getName(),
            'format'            => $dataFormat,
            'url'               => '/' . strtolower($dtoClassName)
        ));
    }
}