import * as React from 'react';
import SourceCard from './SourceCard';
import ResourceList from '../../Components/ResourceList';
import SourceCollectionInterface from '../../../Interfaces/Collections/Token/SourceCollectionInterface';

interface SourceListProps {
	sources: SourceCollectionInterface;
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
