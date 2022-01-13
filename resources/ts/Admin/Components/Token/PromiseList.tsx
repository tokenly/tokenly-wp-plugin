import * as React from 'react';
import { Component } from 'react';
import PromiseCard from './PromiseCard';
import ResourceList from '../../Components/ResourceList';

import { 
	Flex,
} from '@wordpress/components';

interface PromiseListProps {
	promises: Array<any>;
}

export default function PromiseList( props: PromiseListProps ) {
	return (
		<ResourceList
			items={ props.promises }
			component={ PromiseCard }
			itemProp="promise"
			notFoundLabel="promises"
		/>
	);
}
