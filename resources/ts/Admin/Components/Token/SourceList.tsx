import * as React from 'react';
import { Component } from 'react';
import SourceCard from './SourceCard';
import ResourceList from '../../Components/ResourceList';

import { 
	Flex,
} from '@wordpress/components';

interface SourceListProps {
	sources: Array<any>;
}

export default function SourceList( props: SourceListProps ) {
	return (
		<ResourceList
			items={ props.sources }
			component={ SourceCard }
			itemProp="source"
			notFoundLabel="sources"
		/>
	);
}
